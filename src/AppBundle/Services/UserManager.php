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
}