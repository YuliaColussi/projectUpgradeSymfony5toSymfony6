<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Security\AccountNotVerifiedAuthenticationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    public function onAuthenticationSuccessEvent(AuthenticationSuccessEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        if (!$user instanceof User) {
            return;
        }
        if ($user->getIsVerified()) {
            return;
        }

        throw new AccountNotVerifiedAuthenticationException();
    }

    public static function getSubscribedEvents()
    {
        return [
            AuthenticationSuccessEvent::class => 'onAuthenticationSuccessEvent',
        ];
    }
}
