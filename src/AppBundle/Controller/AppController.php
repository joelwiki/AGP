<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/5/18
 * Time: 10:45 PM
 */

namespace AppBundle\Controller;

use AppBundle\Form\GlobalParametersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller {

    /**
     * @return Response
     */
    public function indexAction() {
        return $this->render('@App/App/views/index.html.twig');
    }

    /**
     * @return Response
     */
    public function trombinoscopeAction() {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('@App/Admin/views/trombinoscope.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @return Response
     */
    public function chartreAction() {
        return $this->render('@App/App/views/chartre.html.twig');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function globalParametersAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $global = $em->getRepository('AppBundle:GlobalParameters')->find(1);

        $form = $this->createForm(GlobalParametersType::class, $global);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('agp_dashboard');
        }

        return $this->render('@App/Admin/views/global_parameters.html.twig', array(
            'global' => $global,
            'form' => $form->createView()
        ));
    }
}