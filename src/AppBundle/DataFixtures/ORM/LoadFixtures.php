<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 05/04/18
 * Time: 15:07
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\GlobalParameters;
use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFixtures extends Fixture {

    public function load(ObjectManager $manager) {
        $this->loadUsers($manager);
        $this->loadGroups($manager);
        $this->loadGlobalParameters($manager);
    }

    private function loadUsers(ObjectManager $manager) {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@admin.com');
        $user->setPlainPassword('admin');
        $user->setFirstName('admin');
        $user->setLastName('admin');
        $user->setBirthDate(new \DateTime('1996-01-24'));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEnabled(1);

        $manager->persist($user);

        $manager->flush();
    }

    private function loadGroups(ObjectManager $manager) {
        $group = new Group('10-13', ['ROLE_USER']);
        $group->setMinAge(10);
        $group->setMaxAge(13);
        $manager->persist($group);

        $group = new Group('14-17', ['ROLE_USER']);
        $group->setMinAge(14);
        $group->setMaxAge(17);
        $manager->persist($group);

        $group = new Group('18-100', ['ROLE_USER']);
        $group->setMinAge(18);
        $group->setMaxAge(100);

        $manager->persist($group);

        $manager->flush();
    }

    private function loadGlobalParameters(ObjectManager $manager) {
        $global = new GlobalParameters();
        $global->setMembershipFee(150);
        $global->setRegistrationDateStart(new \DateTime('now'));
        $global->setRegistrationDateEnd(new \DateTime('now'));
        $global->setEndOfYearDate(new \DateTime('now'));
        $global->setSiteName('AGP - Parkour Grenoble');
        $global->setThemeColor('purple');

        $manager->persist($global);

        $manager->flush();
    }
}