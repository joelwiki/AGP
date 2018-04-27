<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 4/27/18
 * Time: 1:30 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Group;
use AppBundle\Form\GroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class GroupController extends Controller {

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_PRESIDENT')")
     */
    public function addGroupAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $group = new Group($name = null);

        $form = $this->createForm(GroupType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('agp_list_groups');
        }

        return $this->render('@App/Admin/views/new_group.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_PRESIDENT')")
     */
    public function editGroupAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $group = $em->getRepository('AppBundle:Group')->find($id);

        $form = $this->createForm(GroupType::class, $group);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('agp_list_groups');
        }

        return $this->render('@App/Admin/views/edit_group.html.twig', array(
            'group' => $group,
            'form' => $form->createView()
        ));
    }

    /**
     * @return Response
     * @Security("has_role('ROLE_PRESIDENT')")
     */
    public function listGroupsAction() {
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('AppBundle:Group')->findAll();

        return $this->render('@FOSUser/Group/list.html.twig', array(
            'groups' => $groups
        ));
    }

    /**
     * @param $id
     * @return RedirectResponse
     * @Security("has_role('ROLE_PRESIDENT')")
     */
    public function deleteGroupAction($id) {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('AppBundle:Group')->find($id);

        $em->remove($group);
        $em->flush();

        return $this->redirectToRoute('agp_list_groups');
    }
}