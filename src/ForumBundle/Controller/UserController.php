<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use ForumBundle\Entity\Topic;
use ForumBundle\Form\TopicType;
use ForumBundle\Entity\User;

use ForumBundle\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;




class UserController extends Controller
{
    public function createAccountAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $passwordEncoder = $this->get('security.password_encoder');

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->container->get('security.token_storage')->setToken($token);
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            $request->getSession()->getFlashBag()->add('notice', 'Votre inscrition est terminée, vous pouvez maintenant profiter pleinement du site.');


            return $this->redirectToRoute('home');
        }
        return $this->render('ForumBundle:User:create_account.html.twig', array('form' => $form->createView()));
    }

    public function accountParametersAction()
    {
        return $this->render('ForumBundle:User:account_parameters.html.twig', array(
            // ...
        ));
    }

    public function newTopicAction(Request $request)
    {
        $topic = new Topic();
        $form   = $this->get('form.factory')->create(TopicType::class, $topic);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
              $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
              if ($this->getUser()) {
                $em = $this->getDoctrine()->getManager();
                $topic->setUser($this->getUser());
                $em->persist($topic);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
              }
              

          return $this->redirectToRoute('topic', array('id' => $topic->getId()));
        }
        
        return $this->render('ForumBundle:User:new_topic.html.twig', array(
             'form' => $form->createView(),
        ));
    }

    public function topicAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository('ForumBundle:Topic')->find($id);
        if(!$topic){
            return new Response("Le topic n'existe pas");
        }
        $comments = $em->getRepository('ForumBundle:Message')->findByTopic($topic);

        return $this->render('ForumBundle:User:topic.html.twig', array(
            "topic"=>$topic,
            "comments"=>$comments
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
          return $this->redirectToRoute('home');
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
