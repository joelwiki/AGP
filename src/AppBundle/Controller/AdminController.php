<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/7/18
 * Time: 2:24 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\HeaderImage;
use AppBundle\Form\GlobalParametersType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller {

    /**
     * Index
     *
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction() {
        return $this->render('@App/Admin/views/index.html.twig');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_PRESIDENT')")
     */
    public function globalParametersAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $global = $em->getRepository('AppBundle:GlobalParameters')->find(1);

        $form = $this->createForm(GlobalParametersType::class, $global);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $today = new \DateTime('now');

            if ($global->getRegistrationDateStart() < $today && $global->getRegistrationDateEnd() > $today) {
                $global->setIsRegistrationOpen(true);
            } else {
                $global->setIsRegistrationOpen(false);
            }

            /** @var HeaderImage $headerImage */
            $headerImage = $global->getHeaderImage();

            if ($headerImage) {
                $global->setHeaderImage($headerImage);
                $headerImage->setGlobal($global);
            }

            $em->flush();

            if ($headerImage) {
                if ($headerImage->getFile()) {
                    $headerImage->upload();
                    $fileName = 'header-' . $global->getId() . '.' . 'png';
                    $headerImage->getFile()->move($headerImage->getUploadDir(), $fileName);
                }
            }

            return $this->redirectToRoute('agp_global_parameters');
        }

        return $this->render('@App/Admin/views/global_parameters.html.twig', array(
            'global' => $global,
            'form' => $form->createView()
        ));
    }

    /**
     * @return Response
     * @Security("has_role('ROLE_AIDE_ENCADRANT')")
     */
    public function trombinoscopeAction() {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('@App/Admin/views/trombinoscope.html.twig', array(
            'users' => $users
        ));
    }
}