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
use AppBundle\Entity\Page;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFixtures extends Fixture {

    public function load(ObjectManager $manager) {
        $this->loadUsers($manager);
        $this->loadGroups($manager);
        $this->loadGlobalParameters($manager);
        $this->loadDefaultPages($manager);
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

    public function loadDefaultPages(ObjectManager $manager) {
        $uniqueId = substr(md5(mt_rand()), 0, 7);

        $page = new Page();
        $page->setTitle('Charte');
        $page->setContent('Modifier le contenu de la charte');
        $page->setUniqueId($uniqueId);
        $page->setSlug('charte');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('Page d\'informations');
        $page->setContent('Modifier le contenu de la page d\'informations');
        $page->setUniqueId($uniqueId);
        $page->setSlug('infos');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('Contact');
        $page->setContent('Modifier le contenu de la page de contact');
        $page->setUniqueId($uniqueId);
        $page->setSlug('contact');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('A propos');
        $page->setContent('Modifier le contenu de la page A propos');
        $page->setUniqueId($uniqueId);
        $page->setSlug('a-propos');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('Partenaires');
        $page->setContent('Modifier le contenu de la page Partenaires');
        $page->setUniqueId($uniqueId);
        $page->setSlug('partenaires');
        $manager->persist($page);

        $manager->flush();
    }
}