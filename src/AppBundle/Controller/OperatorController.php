<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OperatorController extends Controller
{
    /**
     * @Route("/operators", name="operators")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();    

        $customer = $em->getRepository('AppBundle:Customer')->findOneById(1);        
        
        $restresult = $em->getRepository('AppBundle:Operator')->findByCustomer($customer);
        
        return $this->render('default/index.html.twig', [
            'result' => $restresult,
        ]);
    }
    
}
