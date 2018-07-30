<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 05/04/18
 * Time: 16:35
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RegistrationListener implements EventSubscriberInterface {

    protected $em;
    protected $user;
    protected $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container) {
        $this->em = $em;
        $this->container = $container;
    }

    public static function getSubscribedEvents() {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => 'registrationSuccess'
        ];
    }

    public function registrationSuccess(FormEvent $event) {
        $this->getAgeFromBirthDate($event);
        $this->addUserToGroup($event);
    }

    public function addUserToGroup(FormEvent $event) {
        /** @var User $user */
        $user = $event->getForm()->getData();

        $this->container->get('app.user_manager')->assignGroupToAUserByAge($user);
    }

    public function getAgeFromBirthDate(FormEvent $event) {
        $user = $event->getForm()->getData();

        $today = new \DateTime('now');
        $interval = $user->getBirthDate()->diff($today);

        $user->setAge($interval->y);
    }
}