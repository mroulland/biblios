<?php

namespace App\EventListener;

use App\Entity\User;
use DateTimeZone;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

final class LoginListener
{


    public function __construct(
        private readonly EntityManagerInterface $manager, 
        private LoggerInterface $logger)
    {


    }


    #[AsEventListener(event: 'security.interactive_login')]
    public function onInteractiveLogin(InteractiveLoginEvent $event): void
    {
    
        $user = $event->getAuthenticationToken()->getUser();
    
        if($user instanceof User){
            $user->setLastConnectedAt(new \DateTimeImmutable());
            $this->manager->flush();
        }
    }
}