<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Firefighter;

/**
 * Customer controller.
 *
 * @Route("/firefighters")
 */
class FirefighterController extends Controller
{
    protected $user;
    protected $customer;

    public function __construct() {
        $session =          new Session();
        $this->user =       $session->get('session_user');
        $this->customer =   $session->get('session_customer');
    }


    /**
     * @Route("/", name="firefighters")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $customer = $this->customer;

        $result = $em->getRepository('AppBundle:Firefighter')->findByCustomer($customer);

        return $this->render('firefighter/index.html.twig', [
            'results' => $result,
        ]);
    }

    /**
     * @Route("/new", name="firefighter_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $customer = $this->customer;
        $customer = $em->getRepository('AppBundle:Customer')->findOneById($customer);

        $firefighter = new firefighter();

        $form = $this->createForm('AppBundle\Form\FirefighterType', $firefighter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $firefighter->setFullName($firefighter->getFullName());
            $firefighter->setPhoneNumber($firefighter->getPhoneNumber());
            $firefighter->setEnabled(1);
            $firefighter->setCustomer($customer);

            $em->persist($firefighter);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'firefighter bol uspesne pridany.');
            return $this->redirectToRoute('firefighters');
        }

        return $this->render('firefighter/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/change/{id}/{type}", name="firefighter_change")
     * @Method({"POST"})
     */
    public function changeAction(Request $request,$id,$type)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $firefighter = $em->getRepository('AppBundle:Operator')->getFirefighterById($id,$customer);

        if ($firefighter) {
            if ($type == 1) { $firefighter->setEnabled(true); }
            if ($type == 0) { $firefighter->setEnabled(false); }
            $em->persist($firefighter);
            $this->get('session')->getFlashBag()->add('notice', 'firefighter bol editovany uspesne.');
        }

        $em->flush();
        return $this->redirectToRoute('firefighters');

    }

    /**
     * @Route("/edit/{id}", name="firefighter_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,$id)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $firefighter = $em->getRepository('AppBundle:Operator')->getFirefighterById($id,$customer);

        if ( $firefighter ) {
            $form = $this->createForm('AppBundle\Form\FirefighterType', $firefighter);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $firefighter->setFullName($firefighter->getFullName());
                $firefighter->setPhoneNumber($firefighter->getPhoneNumber());
                $em->persist($firefighter);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'firefighter bol editovany uspesne.');
                return $this->redirectToRoute('firefighters');
            }

            return $this->render('firefighter/edit.html.twig', array(
                'form' => $form->createView(),
            ));
        } else {
            $this->get('session')->getFlashBag()->add('warning', 'firefighter nebol editovany.');
            return $this->redirectToRoute('firefighters');
        }

    }

    /**
     * @Route("/del/{id}", name="firefighter_delete")
     * @Method({"POST"})
     */
    public function deleteAction(Request $request,$id)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $firefighter = $em->getRepository('AppBundle:Operator')->getFirefighterById($id,$customer);

        if ($firefighter) {
            $em->remove($firefighter);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'firefighter bol uspesne vymazany.');
        } else {
            $this->get('session')->getFlashBag()->add('warning', 'firefighter nebol vymazany.');
        }

        return $this->redirectToRoute('firefighters');
    }    
    
}
