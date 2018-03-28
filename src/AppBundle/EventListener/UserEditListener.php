<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/8/18
 * Time: 4:58 PM
 */

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use AppBundle\Entity\User;

class UserEditListener implements EventSubscriberInterface {

    protected $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public static function getSubscribedEvents(){
        return [
            FOSUserEvents::PROFILE_EDIT_INITIALIZE => 'onEditInitialize'
        ];
    }

    public function onEditInitialize(GetResponseUserEvent $event) {

        /** @var User $user */
        $user = $event->getUser();

        $this->twig->addGlobal('user', $user);
    }
}