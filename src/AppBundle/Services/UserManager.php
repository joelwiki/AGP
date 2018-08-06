<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 05/04/18
 * Time: 15:34
 */

namespace AppBundle\Services;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager {
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function getAgeFromBirthDate(User $user) {
        $today = new \DateTime('now');
        $interval = $user->getBirthDate()->diff($today);

        $user->setAge($interval->y);
    }

    public function assignGroupToAUserByAge(User $user = null) {
        $users = [];

        if ($user == null) {
            $users[] = $this->em->getRepository('AppBundle:User')->findAll();
        } else {
            $users[] = $user;
        }

        foreach ($users as $user) {
            $group = $this->em->getRepository('AppBundle:Group')->findGroupByAge($user);
            $user->setGroup($group);

            if ($user->getId()) {
                $this->em->flush();
            }
        }

        return true;
    }

    public function assignGroupToAChildByAge(User $children = null) {
        $childrens = [];

        if ($children == null) {
            $childrens[] = $this->em->getRepository('AppBundle:User')->findAll();
        } else {
            $childrens[] = $children;
        }

        foreach ($childrens as $children) {
            $group = $this->em->getRepository('AppBundle:Group')->findGroupByAge($children);
            $children->setGroup($group);

            if ($children->getId()) {
                $this->em->flush();
            }
        }

        return true;
    }
}