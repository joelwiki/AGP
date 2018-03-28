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
use AppBundle\Form\DossierType;
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
        $medicalCertificate = new MedicalCertificate();
        $medicalCertificateImage = new MedicalCertificateImage();
        $civilCertificate = new CivilCertificate();

        $medicalCertificate->setImage($medicalCertificateImage);
        $medicalCertificateImage->setMedicalCertificate($medicalCertificate);

        $dossier->setMedicalCertificate($medicalCertificate);
        $medicalCertificate->setDossier($dossier);

        $civilCertificate->setDossier($dossier);
        $dossier->setCivilLiabilityCertificate($civilCertificate);

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

            /** @var MedicalCertificateImage $medicalCertificateImage */
            $medicalCertificateImage = $medicalCertificate->getImage();
            $medicalCertificateImage->setSize($medicalCertificateImage->getFile()->getSize());

            /** Set size of civil certificate */
            $civilCertificate->setSize($civilCertificate->getFile()->getSize());

            /** Format birthDate */
            $birthDate = explode('/', $dossier->getBirthDate());
            $birthDate = new \DateTime($birthDate[2]. '-' . $birthDate[1] . '-' . $birthDate[0]);

            $dossier->setBirthDate($birthDate);

            /** Format phone numbers */
            $phone = str_replace(' ', '', $dossier->getPhone());
            $contactPhone = str_replace(' ', '', $dossier->getEmergencyContactPhone());
            $contactTwoPhone = str_replace(' ', '', $dossier->getEmergencyContactTwoPhone());
            $doctorPhone = str_replace(' ', '', $dossier->getMedicalCertificate()->getDoctorPhone());

            $dossier->setPhone($phone);
            $dossier->setEmergencyContactPhone($contactPhone);
            $dossier->setEmergencyContactTwoPhone($contactTwoPhone);
            $dossier->getMedicalCertificate()->setDoctorPhone($doctorPhone);
            
            $em->persist($dossier);
            $em->flush();

            $fileName = 'certificat-' . $dossier->getUniqueId() . '.' . $medicalCertificateImage->getExtension();
            $medicalCertificateImage->getFile()->move($medicalCertificateImage->getUploadDir(), $fileName);

            $fileName = 'attestation-' . $dossier->getUniqueId() . '.' . $civilCertificate->getExtension();
            $civilCertificate->getFile()->move($civilCertificate->getUploadDir(), $fileName);

            return $this->redirectToRoute('agp_dashboard');
        }

        return $this->render('@App/Admin/views/new_dossier.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @param $id
     * @param $dossierId
     * @return Response
     */
    public function showDossierAction($id, $dossierId) {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($id);
        $dossier = $em->getRepository('AppBundle:User')->find($dossierId);

        return $this->render('@App/Admin/views/show_dossier.html.twig', array(
            'user' => $user,
            'dossier' => $dossier
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @param $dossierId
     * @return RedirectResponse|Response
     */
    public function editDossierAction(Request $request, $id, $dossierId) {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($id);
        $dossier = $em->getRepository('AppBundle:Dossier')->find($dossierId);

        $form = $this->createForm(DossierType::class, $dossier);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** Format birthDate */
            $birthDate = explode('/', $dossier->getBirthDate());
            $birthDate = new \DateTime($birthDate[2]. '-' . $birthDate[1] . '-' . $birthDate[0]);

            $dossier->setBirthDate($birthDate);

            /** Format phone numbers */
            $phone = str_replace(' ', '', $dossier->getPhone());
            $contactPhone = str_replace(' ', '', $dossier->getEmergencyContactPhone());
            $contactTwoPhone = str_replace(' ', '', $dossier->getEmergencyContactTwoPhone());
            $doctorPhone = str_replace(' ', '', $dossier->getMedicalCertificate()->getDoctorPhone());


            $dossier->setPhone($phone);
            $dossier->setEmergencyContactPhone($contactPhone);
            $dossier->setEmergencyContactTwoPhone($contactTwoPhone);
            $dossier->getMedicalCertificate()->setDoctorPhone($doctorPhone);

            /** @var MedicalCertificateImage $medicalCertificateImage */
            $medicalCertificateImage = $dossier->getMedicalCertificate()->getImage();

            if ($medicalCertificateImage->getFile()) {
                $medicalCertificateImage->upload();
                $fileName = 'certificat-' . $dossier->getUniqueId() . '.' . $medicalCertificateImage->getExtension();
                $medicalCertificateImage->getFile()->move($medicalCertificateImage->getUploadDir(), $fileName);
            }

            /** @var CivilCertificate $civilCertificate */
            $civilCertificate = $dossier->getCivilLiabilityCertificate();

            if ($civilCertificate->getFile()) {
                $civilCertificate->upload();
                $fileName = 'attestation-' . $dossier->getUniqueId() . '.' . $civilCertificate->getExtension();
                $civilCertificate->getFile()->move($civilCertificate->getUploadDir(), $fileName);
            }

            $em->flush();

            return $this->redirectToRoute('agp_dashboard');
        }

        return $this->render('@App/Admin/views/edit_dossier.html.twig', array(
            'user' => $user,
            'dossier' => $dossier,
            'form' => $form->createView()
        ));
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

        $dossier->setEnabled(0);
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
            $birthDate = new \DateTime($birthDate[2]. '-' . $birthDate[1] . '-' . $birthDate[0]);

            $today = new \DateTime('now');

            $interval = $birthDate->diff($today);

            return new JsonResponse($interval->y, 200);
        }

        return new JsonResponse("Fail", 200);
    }
}