<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 05/04/18
 * Time: 15:07
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFixtures extends Fixture {

    public function load(ObjectManager $manager) {
        $this->loadGroups($manager);
    }

    private function loadGroups(ObjectManager $manager) {
        $group = new Group('10-13', ['ROLE_USER']);
        $group->setMinAge(10);
        $group->setMaxAge(13);
        $manager->persist($group);

        $group = new Group('13-15', ['ROLE_USER']);
        $group->setMinAge(13);
        $group->setMaxAge(15);
        $manager->persist($group);

        $group = new Group('15-17', ['ROLE_USER']);
        $group->setMinAge(15);
        $group->setMaxAge(17);
        $manager->persist($group);

        $manager->flush();
    }
}