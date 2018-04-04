<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/5/18
 * Time: 10:45 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}