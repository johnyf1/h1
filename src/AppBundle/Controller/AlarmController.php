<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AlarmController extends Controller
{
    /**
     * @Route("/alarms", name="alarms")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();    

        $customer = $em->getRepository('AppBundle:Customer')->findOneById(1);        
        
        $results = $em->getRepository('AppBundle:Alarm')->findByCustomer($customer);
        
        return $this->render('alarm/index.html.twig', [
            'results' => $results,
        ]);
    }
    
}
