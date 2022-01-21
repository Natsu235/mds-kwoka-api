<?php

namespace App\Events;

use DateTime;
use App\Entity\User;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberinterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordEncoderSubscriber implements EventSubscriberinterface {

    /** @var UserPasswordHasherInterface */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder) {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents() {

        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }

    public function encodePassword(ViewEvent $event) {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();    // GET, POST, PUT...

        if ($user instanceof User && $method === "POST") {
            $hash = $this->encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setCreationDate(new DateTime());
        }
    }
}
