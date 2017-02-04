<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class LoginListener implements EventSubscriberInterface
{
//    /**
//     * @var string
//     */
//    protected $locale;
// 
    /**
     * Router
     *
     * @var Router
     */
    protected $router;
 
    /**
     * @var SecurityContext
     */
    protected $securityContext;
 
    /**
     * @param SecurityContext $securityContext
     * @param Router $router The router
     */
    public function __construct(SecurityContext $securityContext, Router $router)
    {
        $this->securityContext = $securityContext;
        $this->router = $router;
    }
 
    public function handle(AuthenticationEvent $event)
    {
       $token = $event->getAuthenticationToken();
       //$this->locale = $token->getUser()->getLocale();
       #set sessions
       return $this->redirectToRoute('homepage');
    }
 
    public function onKernelResponse(FilterResponseEvent $event)
    {
       return $this->redirectToRoute('homepage');
 
//        if (null !== $this->locale) {
//            $request = $event->getRequest();
//            $request->getSession()->set('_locale', $this->locale);
//        }
    }
}

