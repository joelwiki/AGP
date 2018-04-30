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
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findLastThreeArticles();

        return $this->render('@App/App/views/index.html.twig', array(
            'articles' => $articles
        ));
    }

    /**
     * @return Response
     */
    public function loginAction() {
        return $this->render('@FOSUser/Security/login.html.twig');
    }

    /**
     * @return Response
     */
    public function newsAction() {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAllArticlesByDateDesc();
        $mostViewedArticles = $em->getRepository('AppBundle:Article')->findMostViewedArticles();
        $lastFourArticles = $em->getRepository('AppBundle:Article')->findLastFourArticles();

        return $this->render('@App/App/views/news.html.twig', array(
            'articles' => $articles,
            'mostViewedArticles' => $mostViewedArticles,
            'lastFourArticles' => $lastFourArticles
        ));
    }

    /**
     * @return Response
     */
    public function initiationsAction() {
        $em = $this->getDoctrine()->getManager();
        $initiations = $em->getRepository('AppBundle:Initiation')->findAll();

        return $this->render('@App/App/views/initiations.html.twig', array(
            'initiations' => $initiations
        ));
    }

    /**
     * @return Response
     */
    public function trainingsAction() {
        $em = $this->getDoctrine()->getManager();
        $trainings = $em->getRepository('AppBundle:Training')->findLastTenArticles();

        return $this->render('@App/App/views/trainings.html.twig', array(
            'trainings' => $trainings
        ));
    }
}