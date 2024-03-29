<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/9/18
 * Time: 3:17 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\CivilCertificate;
use AppBundle\Entity\Dossier;
use AppBundle\Entity\DossierImage;
use AppBundle\Entity\MedicalCertificate;
use AppBundle\Entity\MedicalCertificateImage;
use AppBundle\Entity\MedicalCertificateSurveyImage;
use AppBundle\Form\CivilCertificateType;
use AppBundle\Form\DossierType;
use AppBundle\Form\MedicalCertificateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DossierController extends Controller {
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_USER')")
     */
    public function newDossierAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $request->get('userId') ? $id = $request->get('userId') : $id = 0;

        $dossier = new Dossier();

        $form = $this->createForm(DossierType::class, $dossier);

        $form->handleRequest($request);

        if (!$user = $em->getRepository('AppBundle:User')->find($id)) {
            $user = $this->getUser();
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $dossier->setUser($user);

            $uniqueId = substr(md5(mt_rand()), 0, 7);
            $dossier->setUniqueId($uniqueId);

            if ($data = $request->request->get('base64File')['image']) {

                $dossier->getImage() ? $image = $dossier->getImage() : $image = new DossierImage();

                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = str_replace('data:image/png;base64,', '', $data);
                $data = str_replace(' ', '+', $data);

                $data = base64_decode($data);

                $imageName = 'image-' . $dossier->getUniqueId() . '.png';

                file_put_contents('uploads/dossier/image/' . $imageName, $data);

                $file = new UploadedFile('uploads/dossier/image/' . $imageName, $imageName, 'image/png');

                $image->setDossier($dossier);
                $dossier->setImage($image);
                $image->setFile($file);
            }

            $dossier->setEnabled(0);

            $em->persist($dossier);
            $em->flush();

            return $this->redirectToRoute('agp_edit_dossier', array(
                'id' => $user->getId(),
                'dossierId' => $dossier->getId()
            ));
        }

        $global = $em->getRepository('AppBundle:GlobalParameters')->find(1);
        $today = new \DateTime('now');

        if (($today > $global->getRegistrationDateStart()) && ($today < $global->getRegistrationDateEnd())) {
            return $this->render('@App/Admin/views/new_dossier.html.twig', array(
                'form' => $form->createView(),
                'user' => $user
            ));
        } else {
            return $this->render('@App/error/errorRegistrationBlocked.html.twig', array(
                'globalStart' => $global->getRegistrationDateStart(),
                'globalEnd' => $global->getRegistrationDateEnd(),
            ));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @param $dossierId
     * @return RedirectResponse|Response
     * @throws \Exception
     * @Security("has_role('ROLE_USER')")
     */
    public function editDossierAction(Request $request, $id, $dossierId) {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($id);
        $currentUser = $this->getUser();
        $dossier = $em->getRepository('AppBundle:Dossier')->find($dossierId);

        if ($currentUser->getId() == $user->getId() || $this->get('security.authorization_checker')->isGranted('ROLE_MEMBRE_CA') || $currentUser->getId() == $user->getParent()->getId()) {
            if (NULL == $medicalCertificate = $dossier->getMedicalCertificate()) {
                $medicalCertificate = new MedicalCertificate();
                $medicalCertificate->setDossier($dossier);
            }
            if (NULL == $civilCertificate = $dossier->getCivilLiabilityCertificate()) {
                $civilCertificate = new CivilCertificate();
                $civilCertificate->setDossier($dossier);
            }

            $form = $this->createForm(DossierType::class, $dossier);
            $formMedical = $this->createForm(MedicalCertificateType::class, $medicalCertificate);
            $formCivil = $this->createForm(CivilCertificateType::class, $civilCertificate);

            $form = $form->handleRequest($request);
            $formMedical = $formMedical->handleRequest($request);
            $formCivil = $formCivil->handleRequest($request);

            // Submit main form
            if ($form->isSubmitted() && $form->isValid()) {

                $em->flush();

                return $this->redirectToRoute('agp_edit_dossier', array(
                    'id' => $dossier->getUser()->getId(),
                    'dossierId' => $dossier->getId(),
                    '_fragment' => 'infos'
                ));
            }

            // Submit medical form
            if ($formMedical->isSubmitted() && $formMedical->isValid()) {

                if (NULL == $medicalCertificateImage = $medicalCertificate->getImage()) {
                    $medicalCertificateImage = new MedicalCertificateImage();
                }

                if (NULL == $medicalCertificateSurvey = $medicalCertificate->getMedicalSurvey()) {
                    $medicalCertificateSurvey = new MedicalCertificateSurveyImage();
                }

                $medicalCertificate->setImage($medicalCertificateImage, $medicalCertificateSurvey);
                $medicalCertificateImage->setMedicalCertificate($medicalCertificate);
                $medicalCertificateSurvey->setMedicalCertificate($medicalCertificate);

                if ($medicalCertificateImage->getId()) {
                    $medicalCertificateImage->upload();
                }

                if ($medicalCertificateImage->getFile() != NULL) {
                    $fileName = 'certificat-' . $dossier->getUniqueId() . '.' . $medicalCertificateImage->getFile()->getClientOriginalExtension();
                    $medicalCertificateImage->getFile()->move($medicalCertificateImage->getUploadDir(), $fileName);
                    $medicalCertificateImage->setSize($medicalCertificateImage->getFile()->getClientSize());
                }

                if ($medicalCertificateSurvey->getFile() != NULL) {
                    $fileName = 'questionnaire-' . $dossier->getUniqueId() . '.' . $medicalCertificateSurvey->getFile()->getClientOriginalExtension();
                    $medicalCertificateSurvey->getFile()->move($medicalCertificateSurvey->getUploadDir(), $fileName);
                    $medicalCertificateSurvey->setSize($medicalCertificateSurvey->getFile()->getClientSize());
                }

                if (!$medicalCertificateImage->getId()) {
                    $em->persist($medicalCertificateImage);
                }

                $medicalCertificate->setDoctorPhone(str_replace(' ', '', $medicalCertificate->getDoctorPhone()));

                if (!$medicalCertificate->getId()) {
                    $em->persist($medicalCertificate);
                }

                $em->flush();

                return $this->redirectToRoute('agp_edit_dossier', array(
                    'id' => $dossier->getUser()->getId(),
                    'dossierId' => $dossier->getId(),
                    '_fragment' => 'documents'
                ));
            }

            // Submit civil form
            if ($formCivil->isSubmitted() && $formCivil->isValid()) {
                if ($civilCertificate->getId()) {
                    $civilCertificate->upload();
                }

                if ($civilCertificate->getFile() != NULL) {
                    $fileName = 'attestation-' . $dossier->getUniqueId() . '.' . $civilCertificate->getFile()->getClientOriginalExtension();
                    $civilCertificate->getFile()->move($civilCertificate->getUploadDir(), $fileName);
                    $civilCertificate->setSize($civilCertificate->getFile()->getClientSize());
                }

                if (!$civilCertificate->getId()) {
                    $em->persist($civilCertificate);
                }

                $em->persist($civilCertificate);

                $em->flush();

                return $this->redirectToRoute('agp_edit_dossier', array(
                    'id' => $dossier->getUser()->getId(),
                    'dossierId' => $dossier->getId(),
                    '_fragment' => 'documents'
                ));
            }

            return $this->render('@App/Admin/views/edit_dossier.html.twig', array(
                'user' => $user,
                'dossier' => $dossier,
                'form' => $form->createView(),
                'formMedical' => $formMedical->createView(),
                'formCivil' => $formCivil->createView()
            ));
        } else {
            throw new \Exception('Vous ne pouvez pas modifier ce dossier.');
        }
    }

    /**
     * @param Request $request
     * @param Dossier $dossier
     * @return JsonResponse
     */
    public function editDossierImageAction(Request $request, Dossier $dossier) {
        $em = $this->getDoctrine()->getManager();

        if ($data = $request->request->get('image')) {
            $dossier->getImage() ? $image = $dossier->getImage() : $image = new DossierImage();

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);

            $data = base64_decode($data);

            $imageName = 'image-'.$dossier->getUniqueId().'.png';

            file_put_contents('uploads/dossier/image/'.$imageName, $data);

            $file = new UploadedFile('uploads/dossier/image/'. $imageName, $imageName,  'image/png');

            $image->setDossier($dossier);
            $dossier->setImage($image);
            $image->setFile($file);

            $em->flush();

            return new JsonResponse("Image changed", 200);
        }
        return new JsonResponse("Image not changed", 500);
    }

    /**
     * @param $id
     * @param $dossierId
     * @return Response
     * @throws \Exception
     * @Security("has_role('ROLE_USER')")
     */
    public function showDossierAction($id, $dossierId) {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($id);
        $currentUser = $this->getUser();

        if ($currentUser->getId() == $user->getId() || $this->get('security.authorization_checker')->isGranted('ROLE_MEMBRE_CA') || $currentUser->getId() == $user->getParent()->getId()) {
            $dossier = $em->getRepository('AppBundle:User')->find($dossierId);

            return $this->render('@App/Admin/views/show_dossier.html.twig', array(
                'user' => $user,
                'dossier' => $dossier
            ));
        } else {
            throw new \Exception('Vous ne pouvez pas modifier ce dossier.');
        }
    }

    /**
     * @return Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function listDossiersAction() {
        $em = $this->getDoctrine()->getManager();
        $dossiers = $em->getRepository('AppBundle:Dossier')->findAll();

        return $this->render('@App/Admin/views/list_dossiers.html.twig', array(
            'dossiers' => $dossiers
        ));
    }

    /**
     * Deactivate dossier
     *
     * @param $dossierId
     * @return RedirectResponse
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function deactivateDossierAction($dossierId) {
        $em = $this->getDoctrine()->getManager();
        $dossier = $em->getRepository('AppBundle:Dossier')->find($dossierId);

        $dossier->setEnabled(3);

        $user = $dossier->getUser();

        if (!$_array = array_intersect(['ROLE_ADMIN', 'ROLE_PRESIDENT', 'ROLE_MEMBRE_CA', 'ROLE_ENCADRANT', 'ROLE_AIDE_ENCADRANT'], $user->getRoles())) {
            $user->setRoles(['ROLE_USER']);
        }

        $em->flush();

        return $this->redirectToRoute('agp_list_dossiers');
    }

    /**
     * Reject dossier
     *
     * @param $dossierId
     * @return RedirectResponse
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function rejectDossierAction($dossierId) {
        $em = $this->getDoctrine()->getManager();
        $dossier = $em->getRepository('AppBundle:Dossier')->find($dossierId);

        $dossier->setEnabled(2);
        $em->flush();

        return $this->redirectToRoute('agp_list_dossiers');
    }

    /**
     * Activate dossier
     *
     * @param $dossierId
     * @return RedirectResponse
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function activateDossierAction($dossierId) {
        $em = $this->getDoctrine()->getManager();
        $dossier = $em->getRepository('AppBundle:Dossier')->find($dossierId);

        $dossier->setEnabled(1);

        $user = $dossier->getUser();

        if (!$_array = array_intersect(['ROLE_ADMIN', 'ROLE_PRESIDENT', 'ROLE_MEMBRE_CA', 'ROLE_ENCADRANT', 'ROLE_AIDE_ENCADRANT'], $user->getRoles())) {
            $user->setRoles(['ROLE_MEMBRE']);
        }

        $em->flush();

        return $this->redirectToRoute('agp_list_dossiers');
    }

    /**
     * Reset dossier
     *
     * @param $dossierId
     * @return RedirectResponse
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function resetDossierAction($dossierId) {
        $em = $this->getDoctrine()->getManager();
        $dossier = $em->getRepository('AppBundle:Dossier')->find($dossierId);

        $dossier->setEnabled(0);

        $user = $dossier->getUser();

        if (!$_array = array_intersect(['ROLE_ADMIN', 'ROLE_PRESIDENT', 'ROLE_MEMBRE_CA', 'ROLE_ENCADRANT', 'ROLE_AIDE_ENCADRANT'], $user->getRoles())) {
            $user->setRoles(['ROLE_USER']);
        }

        $em->flush();

        return $this->redirectToRoute('agp_list_dossiers');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function calculateAgeAction(Request $request) {

        if ($data = $request->request->get('date')) {

            $birthDate = explode('/', $data);
            $birthDate = new \DateTime($birthDate[2] . '-' . $birthDate[1] . '-' . $birthDate[0]);

            $today = new \DateTime('now');

            $interval = $birthDate->diff($today);

            return new JsonResponse($interval->y, 200);
        }

        return new JsonResponse("Error", 500);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function calculateMedicalCertificateDateAction(Request $request) {

        if ($data = $request->request->get('date')) {

            $medicalCertificateDate = explode('/', $data);
            $medicalCertificateDate = new \DateTime($medicalCertificateDate[2] . '-' . $medicalCertificateDate[1] . '-' . $medicalCertificateDate[0]);

            $today = new \DateTime('now');

            $interval = $medicalCertificateDate->diff($today);

            return new JsonResponse(($interval->format('%y') * 12) + $interval->format('%m'), 200);
        }

        return new JsonResponse("Error", 500);
    }

    /**
     * @param $dossierId
     * @return RedirectResponse
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function deleteDossierAction($dossierId) {
        $em = $this->getDoctrine()->getManager();
        $dossier = $em->getRepository('AppBundle:Dossier')->find($dossierId);

        $em->remove($dossier);
        $em->flush();

        return $this->redirectToRoute('agp_list_dossiers');
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function fpkAddRegisteredAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $dossier = $em->getRepository('AppBundle:Dossier')->find($id);

        if ($data = $request->request->get('checkboxValue') == "true") {

            $dossier->setFpkRegistered(1);

            $em->flush();

            return new JsonResponse(200);
        }

        return new JsonResponse("Error", 500);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function fpkRemoveRegisteredAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $dossier = $em->getRepository('AppBundle:Dossier')->find($id);

        if ($data = $request->request->get('checkboxValue') == "false") {

            $dossier->setFpkRegistered(0);

            $em->flush();

            return new JsonResponse(200);
        }

        return new JsonResponse("Error", 500);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function editPaidAmountAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $dossier = $em->getRepository('AppBundle:Dossier')->find($id);

        $amount = $request->request->get('newAmount');

        if ($data = $amount) {

            $dossier->setPaidAmount($amount);

            $em->flush();

            return new JsonResponse(200);
        }

        return new JsonResponse("Error", 500);
    }
}