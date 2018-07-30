<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/6/18
 * Time: 2:20 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\ArticleImage;
use AppBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Article;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller {

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function newArticleAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setAuthor($this->getUser());

            $uniqueId = substr(md5(mt_rand()), 0, 7);
            $article->setUniqueId($uniqueId);

            $article->setSlug(mb_strtolower(str_replace("'", "-", str_replace(" ", "-", $this->container->get('app.replace_accented_char')->replace_accented_char($article->getTitle())))));

            if ($data = $request->request->get('base64File')['image']) {

                $article->getImage() ? $image = $article->getImage() : $image = new ArticleImage();

                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = str_replace('data:image/png;base64,', '', $data);
                $data = str_replace(' ', '+', $data);

                $data = base64_decode($data);

                $imageName = 'article-' . $article->getUniqueId() . '.png';

                file_put_contents('uploads/article/' . $imageName, $data);

                $file = new UploadedFile('uploads/article/' . $imageName, $imageName, 'image/png');

                $image->setArticle($article);
                $article->setImage($image);
                $image->setFile($file);
            }

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('agp_list_articles');
        }

        return $this->render('@App/Admin/views/new_article.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $slug
     * @return Response
     */
    public function showArticleAction($slug) {

        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')->findOneBy(['slug' => $slug]);

        $views = $article->getViews();
        $article->setViews($views + 1);

        $em->flush();

        return $this->render('@App/App/views/show_article.html.twig', array(
            'article' => $article,
        ));
    }

    /**
     * @return Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function listArticlesAction() {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAll();

        return $this->render('@App/Admin/views/list_articles.html.twig', array(
            'articles' => $articles
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function editArticleAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')->find($id);

        $form = $this->createForm(ArticleType::class, $article);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('agp_list_articles');
        }

        return $this->render('@App/Admin/views/edit_article.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return JsonResponse
     */
    public function editArticleImageAction(Request $request, Article $article) {
        $em = $this->getDoctrine()->getManager();

        if ($data = $request->request->get('image')) {
            $article->getImage() ? $image = $article->getImage() : $image = new ArticleImage();

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);

            $data = base64_decode($data);

            $imageName = 'article-' . $article->getUniqueId() . '.png';

            file_put_contents('uploads/article/' . $imageName, $data);

            $file = new UploadedFile('uploads/article/' . $imageName, $imageName, 'image/png');

            $image->setArticle($article);
            $article->setImage($image);
            $image->setFile($file);

            $em->flush();

            return new JsonResponse("Image changed", 200);
        }
        return new JsonResponse("Image not changed", 500);
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function deleteArticleAction($id) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('agp_list_articles');
    }
}