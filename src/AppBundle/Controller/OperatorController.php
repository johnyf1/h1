<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Operator;


/**
 * Customer controller.
 *
 * @Route("/operators")
 */
class OperatorController extends Controller
{
    protected $user;
    protected $customer;

    public function __construct() {
        $session =          new Session();
        $this->user =       $session->get('session_user');
        $this->customer =   $session->get('session_customer');
    }

    /**
     * @Route("/", name="operators")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('AppBundle:Operator')->findByCustomer($customer);
        
        return $this->render('operator/index.html.twig', [
            'results' => $result,
        ]);
    }

    /**
     * @Route("/new", name="operator_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $customer = $this->customer;
        $customer = $em->getRepository('AppBundle:Customer')->findOneById($customer);

        $operator = new Operator();
        $form = $this->createForm('AppBundle\Form\OperatorType', $operator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $operator->setFullName($operator->getFullName());
            $operator->setPhoneNumber($operator->getPhoneNumber());
            $operator->setEnabled(1);
            $operator->setCustomer($customer);

            $em->persist($operator);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Operator bol uspesne pridany.');
            return $this->redirectToRoute('operators');
        }

        return $this->render('operator/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/change/{id}/{type}", name="operator_change")
     * @Method({"POST"})
     */
    public function changeAction(Request $request,$id,$type)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $operator = $em->getRepository('AppBundle:Operator')->getOperatorById($id,$customer);

        if ($operator) {
            if ($type == 1) { $operator->setEnabled(true); }
            if ($type == 0) { $operator->setEnabled(false); }
            $em->persist($operator);
            $this->get('session')->getFlashBag()->add('notice', 'Operator bol editovany uspesne.');
        }

        $em->flush();
        return $this->redirectToRoute('operators');

    }

    /**
     * @Route("/edit/{id}", name="operator_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,$id)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $operator = $em->getRepository('AppBundle:Operator')->getOperatorById($id,$customer);

        if ( $operator ) {
            $form = $this->createForm('AppBundle\Form\OperatorType', $operator);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $operator->setFullName($operator->getFullName());
                $operator->setPhoneNumber($operator->getPhoneNumber());
                $em->persist($operator);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Operator bol editovany uspesne.');
                return $this->redirectToRoute('operators');
            }

            return $this->render('operator/edit.html.twig', array(
                'form' => $form->createView(),
            ));
        } else {
            $this->get('session')->getFlashBag()->add('warning', 'Operator nebol editovany.');
            return $this->redirectToRoute('operators');
        }

    }

    /**
     * @Route("/del/{id}", name="operator_delete")
     * @Method({"POST"})
     */
    public function deleteAction(Request $request,$id)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $operator = $em->getRepository('AppBundle:Operator')->getOperatorById($id,$customer);
        if ($operator) {
            $em->remove($operator);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Operator bol uspesne vymazany.');
        } else {
            $this->get('session')->getFlashBag()->add('warning', 'Operator nebol vymazany.');
        }

        return $this->redirectToRoute('operators');
    }

    
}


