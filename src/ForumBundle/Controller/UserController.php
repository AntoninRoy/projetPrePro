<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use ForumBundle\Entity\Topic;


class UserController extends Controller
{
    public function createAccountAction()
    {
        return $this->render('ForumBundle:User:create_account.html.twig', array(
            // ...
        ));
    }

    public function accountParametersAction()
    {
        return $this->render('ForumBundle:User:account_parameters.html.twig', array(
            // ...
        ));
    }

    public function newTopicAction()
    {
        
        
        return $this->render('ForumBundle:User:new_topic.html.twig', array(
            // ...
        ));
    }

    public function topicAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository('ForumBundle:Topic')->find($id);
        if(!$topic){
            return new Response("Le topic n'existe pas");
        }


        return $this->render('ForumBundle:User:topic.html.twig', array(
            "topic"=>$topic,
        ));
        
    }

    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $topics = $em->getRepository('ForumBundle:Topic')->findAll();
        return $this->render('ForumBundle:User:home.html.twig', array(
            "topics"=>$topics
        ));
    }
    public function loginAction(Request $request)
      {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          return $this->redirectToRoute('oc_platform_accueil');
        }

        // Le service authentication_utils permet de récupérer le nom d'utilisateur
        // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
        // (mauvais mot de passe par exemple)
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('ForumBundle:User:login.html.twig', array(
          'last_username' => $authenticationUtils->getLastUsername(),
          'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
      }


}
