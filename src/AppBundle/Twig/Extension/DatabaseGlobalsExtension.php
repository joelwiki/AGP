<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 11/04/18
 * Time: 15:02
 */

namespace AppBundle\Twig\Extension;


use Doctrine\ORM\EntityManager;

class DatabaseGlobalsExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface {

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getGlobals() {
        return array(
            "global" => $this->em->getRepository('AppBundle:GlobalParameters')->find(1),
        );
    }

    public function getName() {
        return "AppBundle:DatabaseGlobalsExtension";
    }

}