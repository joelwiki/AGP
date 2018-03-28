<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/7/18
 * Time: 2:24 PM
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}