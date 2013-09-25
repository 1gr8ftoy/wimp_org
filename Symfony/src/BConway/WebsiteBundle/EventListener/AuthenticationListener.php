<?php

namespace BConway\WebsiteBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class AuthenticationListener
{
    /** @var \Symfony\Component\Security\Core\SecurityContext */
    private $securityContext;

    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /**
     * Constructor
     *
     * @param SecurityContext $securityContext
     * @param Doctrine $doctrine
     */
    public function __construct(SecurityContext $securityContext, Doctrine $doctrine)
    {
        $this->securityContext = $securityContext;
        $this->em = $doctrine->getManager();
    }

    public function onSecurityInteractivelogin(InteractiveLoginEvent $event)
    {
        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            // user has just logged in
            $user = $event->getAuthenticationToken()->getUser();

            $user->setCurrentSignInAt(new \DateTime());
            $user->setSignInCount((int)$user->getSignInCount() + 1);

            $this->em->flush();
        }
    }
}