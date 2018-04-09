<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/7/18
 * Time: 3:53 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\UserImage;
use AppBundle\Form\ProfileType;
use AppBundle\Form\RegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller {

    /**
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function showProfileAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $children = $em->getRepository('AppBundle:User')->getChildrenFromUser($user);

        return $this->render('@App/Admin/views/show_user.html.twig', array(
            'user' => $user,
            'children' => $children
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_USER')")
     */
    public function editProfileAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($this->getUser());

        $form = $this->createForm(ProfileType::class, $user);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('agp_dashboard');
        }

        return $this->render('@App/Admin/views/edit_user.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function showUserAction($id) {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($id);
        $children = $em->getRepository('AppBundle:User')->getChildrenFromUser($user);

        $dossier = $user->getDossier();

        return $this->render('@App/Admin/views/show_user.html.twig', array(
            'user' => $user,
            'dossier' => $dossier,
            'children' => $children
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function editUserAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($id);

        $form = $this->createForm(ProfileType::class, $user);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $birthDate = $user->getBirthDate();
            $today = new \DateTime('now');
            $interval = $birthDate->diff($today);

            $user->setAge($interval->y);

            $em->flush();

            return $this->redirectToRoute('agp_dashboard');
        }

        return $this->render('@App/Admin/views/edit_user.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }

    /**
     * Deactivate user
     *
     * @param $id
     * @return RedirectResponse
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function deactivateUserAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        $user->setEnabled(0);
        $em->flush();

        return $this->redirectToRoute('agp_list_users');
    }

    /**
     * Activate user
     *
     * @param $id
     * @return RedirectResponse
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function activateUserAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        $user->setEnabled(1);
        $em->flush();

        return $this->redirectToRoute('agp_list_users');
    }

    /**
     * @return Response
     * @Security("has_role('ROLE_MEMBRE_CA')")
     */
    public function listUsersAction() {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('@App/Admin/views/list_users.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function editUserImageAction(Request $request, User $user) {
        $em = $this->getDoctrine()->getManager();

        if ($data = $request->request->get('image')) {
            $user->getImage() ? $image = $user->getImage() : $image = new UserImage();

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);

            $data = base64_decode($data);

            $imageName = 'user-'.$user->getId().'.png';

            file_put_contents('uploads/user/'.$imageName, $data);

            $file = new UploadedFile('uploads/user/'. $imageName, $imageName,  'image/png');

            $image->setUser($user);
            $user->setImage($image);
            $image->setFile($file);

            $em->flush();

            return new JsonResponse("Image changed", 200);
        }
        return new JsonResponse("Image not changed", 500);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Exception
     * @Security("has_role('ROLE_USER')")
     */
    public function newChildrenAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $children = new User();

        $form = $this->createForm(RegistrationType::class, $children);

        $form->handleRequest($request);

        if ($request->get('parentId')) {
            $parentUser = $em->getRepository('AppBundle:User')->find($request->get('parentId'));
        } else {
            throw new \Exception('Parent ID doesn\'t exist');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $children->setParent($parentUser);
            $parentUser->addChild($children);
            $children->setEnabled(1);

            $em->persist($children);
            $em->flush();

            return $this->redirectToRoute('agp_new_dossier', array('userId' => $children->getId()));
        }

        return $this->render('@App/Admin/views/new_children.html.twig', array(
            'form' => $form->createView()
        ));
    }
}