<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\User;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    protected $user;
    protected $customer;

    public function __construct() {
        $session =          new Session();
        $this->user =       $session->get('session_user');
        $this->customer =   $session->get('session_customer');
    }

    /**
     * Lists all User entities.
     *
     * @Route("/", name="users")
     * @Method("GET")
     */
    public function indexAction()
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findByCustomer($customer);

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $customer = $this->customer;
        $customer = $em->getRepository('AppBundle:Customer')->findOneById($customer);

        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEmail($user->getEmail());
            $user->setUsername($user->getEmail());
            $user->setFullName($user->getFullName());
            $user->setPlainPassword($user->getPassword());
            $user->setEnabled(true);
            $user->setCustomer($customer);

            $this->get('fos_user.user_manager')->updateUser($user, false);


            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users');
            $this->get('session')->getFlashBag()->add('notice', 'user bol pridany uspesne.');
        }

        return $this->render('user/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/change/{id}/{type}", name="user_change")
     * @Method({"POST"})
     */
    public function changeAction(Request $request,$id,$type)
    {
        $userId = $this->user;
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->getOneById($id,$customer);

        if ($user) {
            if ($user->getId() == $userId) {
                $this->get('session')->getFlashBag()->add('error', 'Nieje mozne deaktivovat aktualne prihlaseneho uzivatela.' );
            } else {
                if ($type == 1) { $user->setEnabled(true); }
                if ($type == 0) { $user->setEnabled(false); }
                $em->persist($user);
                $this->get('session')->getFlashBag()->add('notice', 'user bol editovany uspesne.');
            }

        }

        $em->flush();
        return $this->redirectToRoute('users');

    }

    /**
     * @Route("/edit/{id}", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,$id)
    {
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->getOneById($id,$customer);

        if ( $user ) {
            $form = $this->createForm('AppBundle\Form\UserEditType', $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setFullName($user->getFullName());
                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'user bol editovany uspesne.');
                return $this->redirectToRoute('users');
            }

            return $this->render('user/edit.html.twig', array(
                'form' => $form->createView(),
            ));
        } else {
            $this->get('session')->getFlashBag()->add('warning', 'user nebol editovany.');
            return $this->redirectToRoute('users');
        }

    }

    /**
     * @Route("/del/{id}", name="user_delete")
     * @Method({"POST"})
     */
    public function deleteAction(Request $request,$id)
    {
        $userId = $this->user;
        $customer = $this->customer;

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->getAllMyUsers($customer);

        if( count($users) <= 1 ) {
            $this->get('session')->getFlashBag()->add('error', 'Was not successful, because there is only one user in your list of users!' );
        } else {
            $user = $em->getRepository('AppBundle:User')->getOneById($id,$customer);
            if ($user) {
                //can not delete currently logged user
                if ($user->getId() == $userId) {
                    $this->get('session')->getFlashBag()->add('error', 'Nieje mozne vymazat aktualne prihlaseneho uzivatela.' );
                } else {
                    $em->remove($user);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add('notice', 'user bol uspesne vymazany.' );
                }
            } else {
                $this->get('session')->getFlashBag()->add('warning', 'user nebol vymazany.');
            }
        }



        return $this->redirectToRoute('users');
    }
}
