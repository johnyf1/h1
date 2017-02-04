<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\PhoneNumber;
use AppBundle\Entity\Firefighter;
use AppBundle\Entity\Log;
use AppBundle\Entity\Participation;
use AppBundle\Entity\Alarm;


class ApiRestController extends FOSRestController {

    
    
    /**
    * @Rest\Get("/api/getContext/{number}")
    */
    public function getContextAction(Request $request,$number) {
        $em = $this->getDoctrine()->getManager();    
        $restresult = $em->getRepository('AppBundle:PhoneNumber')->isPhoneNumberPublic($number);
        
        return $restresult;
    }    
    
    /**
    * @Rest\Get("/api/getOperatorsByNumber/{number}")
    */
    public function getOperatorsAction(Request $request,$number) {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:PhoneNumber')->findOneByPhoneNumber($number);
        
        return $restresult;
    }

    /**
    * @Rest\Get("/api/getFirefightersByNumber/{number}")
    */
    public function getFirefightersAction(Request $request,$number) {
       $restresult = $this->getDoctrine()->getRepository('AppBundle:Operator')->findActiveOperatorByPhoneNumber($number);
        
        return $restresult;
    }

    /**
    * @Rest\Get("/api/getOperatorByNumber/{number}")
    */
    public function getOperatorAction(Request $request,$number) {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Operator')->findActiveOperatorByPhoneNumber($number);        
        return $restresult;
    }

    /**
    * @Rest\Get("/api/getFirefighterByNumber/{number}")
    */
    public function getFirefighterAction(Request $request,$number) {
       //$restresult = $this->getDoctrine()->getRepository('AppBundle:Firefighter')->findOneByPhoneNumber($number);        
       $restresult = $this->getDoctrine()->getRepository('AppBundle:Firefighter')->findActiveFirefighterByPhoneNumber($number);
       return $restresult;
    }
    
    
    /**
    * @Rest\Post("/api/postLog")
    */
    public function postLogAction(Request $request) {
        $data = new Log;
        $logLevel       = $request->get('logLevel');
        $customerId     = $request->get('customerId');
        $description    = $request->get('description');
        
        if (empty($description) || empty($logLevel)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $em = $this->getDoctrine()->getManager();    
        if ($customerId != 0) {
            $customer = $em->getRepository('AppBundle:Customer')->findOneById($customerId);
        } else {
            $customer = null;
        }        
        
        $data->setCreated(new \DateTime());
        $data->setCustomer($customer);
        $data->setDescription($description);
        $data->setLogLevel($logLevel);
        
        $em->persist($data);
        $em->flush();
        return new View("LogRow Added Successfully", Response::HTTP_OK);
    }

    /**
    * @Rest\Post("/api/postParticipient")
    */
    public function postParticipientAction(Request $request) {
        $data = new Participation;
        $customerId     = $request->get('customerId');
        $firefighterId  = $request->get('firefighterId');
        $phoneNumber    = $request->get('phoneNumber');
        $participation  = $request->get('participation');
        $alarmId        = $request->get('alarmId');
        
        if (empty($firefighterId) || empty($customerId)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        if ($participation == 0) {
            $participation = false;
        } else {
            $participation = true;
        }
        
        $em = $this->getDoctrine()->getManager();    
        $customer       = $em->getRepository('AppBundle:Customer')->findOneById($customerId);
        $firefighter    = $em->getRepository('AppBundle:Firefighter')->findOneById($firefighterId);
        $alarm          = $em->getRepository('AppBundle:Alarm')->findOneById($alarmId);
        
        $data->setCreated(new \DateTime());        
        $data->setCustomer($customer);
        $data->setFirefighter($firefighter);
        $data->setPhoneNumber($phoneNumber);
        $data->setParticipation($participation);
        $data->setAlarm($alarm);
        
        $em->persist($data);
        $em->flush();
        return new View("Participient Added Successfully", Response::HTTP_OK);
    }    
    
    /**
    * @Rest\Post("/api/postAlarm")
    */
    public function postAlarmAction(Request $request) {
        $data = new Alarm;
        $customerId     = $request->get('customerId');
        $operatorId     = $request->get('operatorId');        
        $callId         = $request->get('callId');
        
        if (empty($operatorId) || empty($customerId)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $em = $this->getDoctrine()->getManager();    
        $customer    = $em->getRepository('AppBundle:Customer')->findOneById($customerId);
        $operator    = $em->getRepository('AppBundle:Operator')->findOneById($operatorId);
        
        $data->setCreated(new \DateTime());        
        $data->setCustomer($customer);
        $data->setOperator($operator);
        $data->setCallId($callId);
        
        $em->persist($data);
        $em->flush();
        
        return $data->getId();
    }      
    
    
}
