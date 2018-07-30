<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/14/18
 * Time: 6:58 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Training;
use AppBundle\Entity\TrainingLocation;
use AppBundle\Entity\TrainingLocationImage;
use AppBundle\Entity\TrainingRef;
use AppBundle\Form\TrainingLocationType;
use AppBundle\Form\TrainingRefType;
use AppBundle\Form\TrainingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrainingController extends Controller {

    /**
     * @param Request $request
     * @return Response
     * @Security("has_role('ROLE_ENCADRANT')")
     */
    public function newTrainingTypeAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $training = new TrainingRef();

        $form = $this->createForm(TrainingRefType::class, $training);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($training);
            $em->flush();

            return $this->redirectToRoute('agp_list_trainings_ref');
        }

        return $this->render('@App/Admin/views/new_training_ref.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @return Response
     * @Security("has_role('ROLE_ENCADRANT')")
     */
    public function newTrainingAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $training = new Training();
        $trainingLocation = new TrainingLocation();

        $form = $this->createForm(TrainingType::class, $training);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $training->setEncadrant($this->getUser());

            $trainingLocation->setTrainings($training);

            $uniqueId = substr(md5(mt_rand()), 0, 7);
            $training->setUniqueId($uniqueId);

            $em->persist($training);
            $em->flush();

            return $this->redirectToRoute('agp_list_trainings');
        }

        return $this->render('@App/Admin/views/new_training.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_ENCADRANT')")
     */
    public function editTrainingAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $training = $em->getRepository('AppBundle:Training')->find($id);

        $form = $this->createForm(TrainingType::class, $training);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var TrainingLocationImage $trainingLocationImage */
            $trainingLocationImage = $training->getTrainingLocation()->getImage();

            if ($trainingLocationImage->getFile()) {
                $trainingLocationImage->upload();
                $fileName = 'training-' . $training->getUniqueId() . '.' . $trainingLocationImage->getExtension();
                $trainingLocationImage->getFile()->move($trainingLocationImage->getUploadDir(), $fileName);
            }

            $em->flush();

            return $this->redirectToRoute('agp_list_trainings');
        }

        return $this->render('@App/Admin/views/edit_training.html.twig', array(
            'training' => $training,
            'form' => $form->createView()
        ));
    }

    /**
     * @return Response
     * @Security("has_role('ROLE_AIDE_ENCADRANT')")
     */
    public function listTrainingsAction() {
        $em = $this->getDoctrine()->getManager();
        $trainings = $em->getRepository('AppBundle:Training')->findAll();

        return $this->render('@App/Admin/views/list_trainings.html.twig', array(
            'trainings' => $trainings
        ));
    }

    /**
     * @param Request $request
     * @return Response
     * @Security("has_role('ROLE_ENCADRANT')")
     */
    public function newTrainingLocationAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $trainingLocation = new TrainingLocation();
        $trainingImage = new TrainingLocationImage();

        $trainingImage->setTraining($trainingLocation);
        $trainingLocation->setImage($trainingImage);

        $form = $this->createForm(TrainingLocationType::class, $trainingLocation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var TrainingLocationImage $trainingImage */
            $trainingImage = $trainingLocation->getImage();

            $em->persist($trainingLocation);
            $em->flush();

            $fileName = 'training-' . $trainingLocation->getId() . '.' . $trainingImage->getExtension();
            $trainingImage->getFile()->move($trainingImage->getUploadDir(), $fileName);

            return $this->redirectToRoute('agp_list_trainings');
        }

        return $this->render('@App/Admin/views/new_training_location.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Security("has_role('ROLE_ENCADRANT')")
     */
    public function deleteTrainingAction($id) {
        $em = $this->getDoctrine()->getManager();
        $training = $em->getRepository('AppBundle:Training')->find($id);

        $em->remove($training);
        $em->flush();

        return $this->redirectToRoute('agp_list_trainings');
    }

    /**
     * @return Response
     * @Security("has_role('ROLE_ENCADRANT')")
     */
    public function listTrainingRefAction() {
        $em = $this->getDoctrine()->getManager();
        $trainingsRef = $em->getRepository('AppBundle:TrainingRef')->findAll();

        return $this->render('@App/Admin/views/list_trainings_ref.html.twig', array(
            'trainingsRef' => $trainingsRef
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_ENCADRANT')")
     */
    public function editTrainingRefAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $trainingRef = $em->getRepository('AppBundle:TrainingRef')->find($id);

        $form = $this->createForm(TrainingRefType::class, $trainingRef);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('agp_list_trainings_ref');
        }

        return $this->render('@App/Admin/views/edit_training_ref.html.twig', array(
            'trainingRef' => $trainingRef,
            'form' => $form->createView()
        ));
    }

    /**
     * @return Response
     * @Security("has_role('ROLE_ENCADRANT')")
     */
    public function listTrainingLocAction() {
        $em = $this->getDoctrine()->getManager();
        $trainingsLoc = $em->getRepository('AppBundle:TrainingLocation')->findAll();

        return $this->render('@App/Admin/views/list_trainings_loc.html.twig', array(
            'trainingsLoc' => $trainingsLoc
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_ENCADRANT')")
     */
    public function editTrainingLocAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $trainingLoc = $em->getRepository('AppBundle:TrainingLocation')->find($id);

        $form = $this->createForm(TrainingLocationType::class, $trainingLoc);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('agp_list_trainings_loc');
        }

        return $this->render('@App/Admin/views/edit_training_location.html.twig', array(
            'trainingLoc' => $trainingLoc,
            'form' => $form->createView()
        ));
    }
}