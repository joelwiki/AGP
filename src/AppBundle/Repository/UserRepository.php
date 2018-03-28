<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/12/18
 * Time: 6:53 PM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {

    public function getChildrenFromUser(User $user) {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('u')
            ->from('AppBundle:User', 'u')
            ->where('u.parent = :user')
            ->setParameter('user', $user);

        return $qb->getQuery()->getArrayResult();
    }
}