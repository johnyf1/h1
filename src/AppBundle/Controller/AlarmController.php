<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AlarmController extends Controller
{
    protected $user;
    protected $customer;

    public function __construct() {
        $session =          new Session();
        $this->user =       $session->get('session_user');
        $this->customer =   $session->get('session_customer');
    }

    /**
     * @Route("/alarms", name="alarms")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();    

        $customer = $this->customer;

        $results = $em->getRepository('AppBundle:Alarm')->findByCustomer($customer);
        
        return $this->render('alarm/index.html.twig', [
            'results' => $results,
        ]);
    }
    
}
