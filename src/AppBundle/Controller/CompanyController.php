<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();    
        $restresult = $em->getRepository('AppBundle:Customer')->findOneById(1);
        
        return $this->render('default/index.html.twig', [
            'result' => $restresult,
        ]);
    }
    
}
