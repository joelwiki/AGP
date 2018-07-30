<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 28/03/18
 * Time: 16:08
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Initiation;
use AppBundle\Form\InitiationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class InitiationController extends Controller {

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function newInitiationAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $initiation = new Initiation();

        $form = $this->createForm(InitiationType::class, $initiation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uniqueId = substr(md5(mt_rand()), 0, 7);
            $initiation->setUniqueId($uniqueId);

            $em->persist($initiation);
            $em->flush();

            return $this->redirectToRoute('agp_list_initiations');
        }

        return $this->render('@App/Admin/views/new_initiation.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function listInitiationsAction() {
        $em = $this->getDoctrine()->getManager();
        $initiations = $em->getRepository('AppBundle:Initiation')->findAll();

        return $this->render('@App/Admin/views/list_initiations.html.twig', array(
            'initiations' => $initiations
        ));
    }

    /**
     * @param Request $request
     * @param $uniqueId
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function editInitiationAction(Request $request, $uniqueId) {
        $em = $this->getDoctrine()->getManager();

        $initiation = $em->getRepository('AppBundle:Initiation')->findOneBy(['uniqueId' => $uniqueId]);

        $form = $this->createForm(InitiationType::class, $initiation);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('agp_list_initiations');
        }

        return $this->render('@App/Admin/views/edit_initiation.html.twig', array(
            'form' => $form->createView(),
            'initiation' => $initiation
        ));
    }

    /**
     * @param $uniqueId
     * @return RedirectResponse
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function deleteInitiationAction($uniqueId) {
        $em = $this->getDoctrine()->getManager();
        $initiation = $em->getRepository('AppBundle:Initiation')->findOneBy(['uniqueId' => $uniqueId]);

        $em->remove($initiation);
        $em->flush();

        return $this->redirectToRoute('agp_list_initiations');
    }

    /**
     * @param $uniqueId
     * @return Response
     */
    public function showInitiationAction($uniqueId) {
        $em = $this->getDoctrine()->getManager();
        $initiation = $em->getRepository('AppBundle:Initiation')->findOneBy(['uniqueId' => $uniqueId]);

        return $this->render('@App/App/views/show_initiation.html.twig', array(
            'initiation' => $initiation,
        ));
    }
}