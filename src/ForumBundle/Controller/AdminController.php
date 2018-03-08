<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends Controller
{

    public function displayAccountAction()
    {
        return $this->render('ForumBundle:Admin:display_account.html.twig', array(
            // ...
        ));
    }

}
