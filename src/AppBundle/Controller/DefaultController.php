<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller 
{
    /**
     * @Route(name="setSessions", path="/set-sessions")
     * @Template()
     */
    public function setSessionsAction()
    {
        $user = $this->getUser();

        if ( $user ) {
            $session = new Session;
            $customer = $user->getCustomer();
            $session->set('session_user', $user->getId());
            $session->set('session_customer', $customer->getId());
//            $session->set('session_user', $user);
//            $session->set('session_customer', $customer);

            return $this->redirectToRoute('homepage');

        } else {
            return $this->redirectToRoute('login');
        }
    }


    
}    
