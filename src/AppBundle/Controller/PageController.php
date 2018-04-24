<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/6/18
 * Time: 2:20 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Entity\PageImage;
use AppBundle\Form\PageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller {

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function newPageAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $page = new Page();

        $form = $this->createForm(PageType::class, $page);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uniqueId = substr(md5(mt_rand()), 0, 7);
            $page->setUniqueId($uniqueId);

            $page->setSlug(mb_strtolower(str_replace("'", "-", str_replace(" ", "-", $this->container->get('app.replace_accented_char')->replace_accented_char($page->getTitle())))));

            if ($data = $request->request->get('base64File')['image']) {

                $page->getImage() ? $image = $page->getImage() : $image = new PageImage();

                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = str_replace('data:image/png;base64,', '', $data);
                $data = str_replace(' ', '+', $data);

                $data = base64_decode($data);

                $imageName = 'page-' . $page->getUniqueId() . '.png';

                file_put_contents('uploads/page/' . $imageName, $data);

                $file = new UploadedFile('uploads/page/' . $imageName, $imageName, 'image/png');

                $image->setPage($page);
                $page->setImage($image);
                $image->setFile($file);
            }

            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('agp_list_pages');
        }

        return $this->render('@App/Admin/views/new_page.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Page $page
     * @return Response
     */
    public function showPageAction(Page $page) {
        return $this->render('@App/App/views/show_page.html.twig', array(
            'page' => $page,
        ));
    }

    /**
     * @return Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function listPagesAction() {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('AppBundle:Page')->findAll();

        return $this->render('@App/Admin/views/list_pages.html.twig', array(
            'pages' => $pages
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function editPageAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('AppBundle:Page')->find($id);

        $form = $this->createForm(PageType::class, $page);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('agp_list_pages');
        }

        return $this->render('@App/Admin/views/edit_page.html.twig', array(
            'page' => $page,
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param Page $page
     * @return JsonResponse
     */
    public function editPageImageAction(Request $request, Page $page) {
        $em = $this->getDoctrine()->getManager();

        if ($data = $request->request->get('image')) {
            $page->getImage() ? $image = $page->getImage() : $image = new PageImage();

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);

            $data = base64_decode($data);

            $imageName = 'page-' . $page->getUniqueId() . '.png';

            file_put_contents('uploads/page/' . $imageName, $data);

            $file = new UploadedFile('uploads/page/' . $imageName, $imageName, 'image/png');

            $image->setPage($page);
            $page->setImage($image);
            $image->setFile($file);

            $em->flush();

            return new JsonResponse("Image changed", 200);
        }
        return new JsonResponse("Image not changed", 500);
    }
}