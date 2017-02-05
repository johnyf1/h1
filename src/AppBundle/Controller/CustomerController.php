<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class CustomerController extends Controller
{
    protected $user;
    protected $customer;

    public function __construct() {
        $session =          new Session();
        $this->user =       $session->get('session_user');
        $this->customer =   $session->get('session_customer');
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();    
        $result = $em->getRepository('AppBundle:Customer')->findOneById($customer);
        
        return $this->render('customer/index.html.twig', [
            'result' => $result,
        ]);
    }
    
}
