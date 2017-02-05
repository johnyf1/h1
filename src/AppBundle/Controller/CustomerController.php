<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\File\File;

use AppBundle\Entity\Recording;

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
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();    
        $customer = $em->getRepository('AppBundle:Customer')->findOneById($customer);

//        $alarms = $em->getRepository('AppBundle:Alarm')->getLastFiveAlarms($customer);
//        $logs = $em->getRepository('AppBundle:Log')->getLastFiveLogs($customer);
        $recs = $em->getRepository('AppBundle:Recording')->getRecordings($customer);

        $form = $this->createForm('AppBundle\Form\CustomerType', $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer->setCustomerName($customer->getCustomerName());
            $customer->setIsSmsEnabled($customer->getIsSmsEnabled());
            $customer->setIsSmsSumarEnabled($customer->getIsSmsSumarEnabled());
            $customer->setSmsSumarNumbers($customer->getSmsSumarNumbers());
            $em->persist($customer);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Nastavenia boli editovane uspesne.');
            return $this->redirectToRoute('homepage');
        }

        $recording = new Recording();
        $recForm = $this->createForm('AppBundle\Form\CustomerRecordingType', $recording);
        $recForm->handleRequest($request);

        if ($recForm->isSubmitted() && $recForm->isValid()) {
            $file = $recording->getRecordingName();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory'),
                $fileName
            );

            $recording->setPath($this->getParameter('upload_directory'));
            $recording->setRecordingName($fileName);
            $recording->setCustomer($customer);
            $em->persist($recording);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Nahravka uploadnuta.');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('customer/index.html.twig', [
            'form' => $form->createView(),
            'recForm' => $recForm->createView(),
            'result' => $customer,
//            'alarms' => $alarms,
//            'logs' => $logs,
            'recordings' => $recs,
        ]);
    }


    /**
     * @Route("/rec-del/{id}", name="rec_delete")
     * @Method({"POST"})
     */
    public function recDeleteAction(Request $request,$id)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository('AppBundle:Recording')->getOneById($id,$customer);
        if ($rec) {
            $em->remove($rec);
            $em->flush();

            $rec_file = $this->getParameter('upload_directory').'/'.$rec->getRecordingName();
            unlink($rec_file);

            $this->get('session')->getFlashBag()->add('notice', 'Nahravka bola uspesne vymazana.');
        } else {
            $this->get('session')->getFlashBag()->add('warning', 'Nahravka nebola vymazana.');
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/set-default/{id}/{type}", name="rec_change")
     * @Method({"POST"})
     */
    public function setDefaultAction(Request $request,$id,$type)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $rec = $em->getRepository('AppBundle:Recording')->getOneById($id,$customer);

        if ($rec) {
            if ($type == 1) { $rec->setIsDefault(true); }
            if ($type == 0) { $rec->setIsDefault(false); }
            $em->persist($rec);
            $this->get('session')->getFlashBag()->add('notice', 'Nahravka hola uspesne zmenena.');
        }

        $em->flush();
        return $this->redirectToRoute('homepage');

    }

}
