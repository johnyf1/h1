<?php

namespace AppBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
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
    * @ApiDoc(
    *  resource=true,
    *  description="If phone number is returned, it means that number is in our database and is public. Otherwise nothing is returnd.",
    *  requirements={
    *      {
    *          "name"="number",
    *          "dataType"="string",
    *          "requirement"="true",
    *          "description"="Phone number must be in inernational format. Returns only one result."
    *      }
    *  },
    * )
    * @Rest\Get("/api/getContext/{number}")
    */
    public function getContextAction(Request $request,$number) {
        $em = $this->getDoctrine()->getManager();    
        $restresult = $em->getRepository('AppBundle:PhoneNumber')->isPhoneNumberPublic($number);
        
        return $restresult;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="searching for an operator by a phone number",
     *  requirements={
     *      {
     *          "name"="number",
     *          "dataType"="string",
     *          "requirement"="true",
     *          "description"="Phone number must be in inernational format. Returns only one result."
     *      }
     *  },
     * )
    * @Rest\Get("/api/getOperatorsByNumber/{number}")
    */
    // fixnut NAZOV - getOperatorsAction to getOperatorAction
    public function getOperatorsAction(Request $request,$number) {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:PhoneNumber')->findOneByPhoneNumber($number);
        return $restresult;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="searching for an active operator by a phone number",
     *  requirements={
     *      {
     *          "name"="number",
     *          "dataType"="string",
     *          "requirement"="true",
     *          "description"="Phone number must be in inernational format. Returns only one result."
     *      }
     *  },
     * )
    * @Rest\Get("/api/getFirefightersByNumber/{number}")
    */
    // fixnut NAZOV - getOperatorsAction to getOperatorAction
    public function getFirefightersAction(Request $request,$number) {
       $restresult = $this->getDoctrine()->getRepository('AppBundle:Operator')->findActiveOperatorByPhoneNumber($number);
        
        return $restresult;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="searching for a firefighter by a phone number",
     *  requirements={
     *      {
     *          "name"="number",
     *          "dataType"="string",
     *          "requirement"="true",
     *          "description"="Phone number must be in inernational format. Returns only one result."
     *      }
     *  },
     * )
    * @Rest\Get("/api/getOperatorByNumber/{number}")
    */
    public function getOperatorAction(Request $request,$number) {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Operator')->findActiveOperatorByPhoneNumber($number);        
        return $restresult;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="searching for an firefighter by a phone number",
     *  requirements={
     *      {
     *          "name"="number",
     *          "dataType"="string",
     *          "requirement"="true",
     *          "description"="Phone number must be in inernational format. Returns only one result."
     *      }
     *  },
     * )
    * @Rest\Get("/api/getFirefighterByNumber/{number}")
    */
    public function getFirefighterAction(Request $request,$number) {
       //$restresult = $this->getDoctrine()->getRepository('AppBundle:Firefighter')->findOneByPhoneNumber($number);        
       $restresult = $this->getDoctrine()->getRepository('AppBundle:Firefighter')->findActiveFirefighterByPhoneNumber($number);
       return $restresult;
    }
    
    
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="creating a new log line",
     *  requirements={
     *      {
     *          "name"="logLevel",
     *          "dataType"="string",
     *          "requirement"="true",
     *          "description"="Options : Info, Warning or Error"
     *      },
     *      {
     *          "name"="customerId",
     *          "dataType"="integer",
     *          "requirement"="false",
     *          "description"="ID of customer from mysql table 'customer'."
     *      },
     *      {
     *          "name"="description",
     *          "dataType"="string",
     *          "requirement"="true",
     *          "description"="Description of the event that is currently processed.."
     *      },
     *  },
     * )
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
     * @ApiDoc(
     *  resource=true,
     *  description="Saves information about the members of firefighters participiate on the alarm or not",
     *  requirements={
     *      {
     *          "name"="customerId",
     *          "dataType"="integer",
     *          "requirement"="true",
     *          "description"="ID of firefighter from mysql table 'firefighter'."
     *      },
     *      {
     *          "name"="firefighterId",
     *          "dataType"="integer",
     *          "requirement"="true",
     *          "description"="ID of customer from mysql table 'customer'."
     *      },
     *      {
     *          "name"="phoneNumber",
     *          "dataType"="string",
     *          "requirement"="true",
     *          "description"="The phone number of a firefighter."
     *      },
     *      {
     *          "name"="participation",
     *          "dataType"="integer",
     *          "requirement"="true",
     *          "description"="Expected value: '1' for participation and '0' for not."
     *      },
     *      {
     *          "name"="alarmId",
     *          "dataType"="integer",
     *          "requirement"="true",
     *          "description"="ID of the alarm that is currently proccessing. From mysql table 'firefighter'."
     *      },
     *  },
     * )
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
     * @ApiDoc(
     *  resource=true,
     *  description="Saves information about an alarm that is currently proccessing.",
     *  requirements={
     *      {
     *          "name"="customerId",
     *          "dataType"="integer",
     *          "requirement"="true",
     *          "description"="ID of customer from mysql table 'customer'."
     *      },
     *      {
     *          "name"="operatorId",
     *          "dataType"="integer",
     *          "requirement"="true",
     *          "description"="ID of operator from mysql table 'operator' that enabled the alarm."
     *      },
     *      {
     *          "name"="callId",
     *          "dataType"="string",
     *          "requirement"="true",
     *          "description"="It used to be CallID of the alarm, but now it is information about the type of alarm. Values are : POZIAR, POVODEN, TECHNICKY ZASAH, ZRUSENIE POPLACHU and TEST SYSTEMU."
     *      },
     *  },
     * )
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
