<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends Controller
{

    public function displayAccountAction()
    {	$em = $this->getDoctrine()->getManager();
    	$users = $em->getRepository('ForumBundle:User')->findAll();
        return $this->render('ForumBundle:Admin:display_account.html.twig', array(
            "users"=> $users
        ));
    }

    public function adminAction()
    {
        return $this->render('ForumBundle:Admin:admin_home.html.twig', array(
            // ...
        ));
    }

}
