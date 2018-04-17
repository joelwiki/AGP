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
     */
    public function globalParametersAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $global = $em->getRepository('AppBundle:GlobalParameters')->find(1);

        $form = $this->createForm(GlobalParametersType::class, $global);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** Format dateRegistrationStart */
            $dateRegistrationStart = explode('/', $global->getRegistrationDateStart());
            $dateRegistrationStart = new \DateTime($dateRegistrationStart[2]. '-' . $dateRegistrationStart[1] . '-' . $dateRegistrationStart[0]);

            $global->setRegistrationDateStart($dateRegistrationStart);

            /** Format dateRegistrationEnd */
            $dateRegistrationEnd = explode('/', $global->getRegistrationDateEnd());
            $dateRegistrationEnd = new \DateTime($dateRegistrationEnd[2]. '-' . $dateRegistrationEnd[1] . '-' . $dateRegistrationEnd[0]);

            $global->setRegistrationDateEnd($dateRegistrationEnd);

            /** Format endOfYearDate */
            $endOfYearDate = explode('/', $global->getEndOfYearDate());
            $endOfYearDate = new \DateTime($endOfYearDate[2]. '-' . $endOfYearDate[1] . '-' . $endOfYearDate[0]);

            $global->setEndOfYearDate($endOfYearDate);

            $today = new \DateTime('now');

            if ($global->getRegistrationDateStart() < $today && $global->getRegistrationDateEnd() > $today) {
                $global->setIsRegistrationOpen(true);
            } else {
                $global->setIsRegistrationOpen(false);
            }

            /** @var HeaderImage $headerImage */
            $headerImage = $global->getHeaderImage();

            $global->setHeaderImage($headerImage);
            $headerImage->setGlobal($global);

            $em->flush();

            if ($headerImage->getFile()) {
                $headerImage->upload();
                $fileName = 'header-' . $global->getId() . '.' . 'png';
                $headerImage->getFile()->move($headerImage->getUploadDir(), $fileName);
            }

            return $this->redirectToRoute('agp_dashboard');
        }

        return $this->render('@App/Admin/views/global_parameters.html.twig', array(
            'global' => $global,
            'form' => $form->createView()
        ));
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
}