<?php

namespace ForumBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use ForumBundle\Entity\User;
use ForumBundle\Entity\Topic;
use ForumBundle\Entity\Message;

class FixturesCommand extends ContainerAwareCommand
{
    //https://symfony.com/doc/3.3/console/input.html
    protected function configure()
    {
        $this
            ->setName('fixtures:add')
            ->setDescription('Ajout de données')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        /*Suppresion de la abse de données*/

        $output->writeln("Suppression de la base de données...");
        $users = $em->getRepository('ForumBundle:User')->findAll();
        $topics = $em->getRepository('ForumBundle:Topic')->findAll();
        $messages = $em->getRepository('ForumBundle:Message')->findAll();

        foreach ($messages as $message) {
          $em->remove($message);
    
        }
        foreach ($topics as $topic) {
          $em->remove($topic);
    
        }
        foreach ($users as $user) {
          $em->remove($user);
    
        }
        $em->flush();
        $output->writeln("Terminé.");

        /*Ajout de comptes*/

        $output->writeln("Ajout de 1 utilisateur (user:user) et un administrateur (admin:admin)...");
        $user = new User();
        $user->setUsername("admin");
        $user->setPassword(password_hash("admin", PASSWORD_BCRYPT));
        $user->setRoles(array('ROLE_ADMIN'));
        $em->persist($user);

        $user2 = new User();
        $user2->setUsername("user");
        $user2->setPassword(password_hash("user", PASSWORD_BCRYPT));
        $user2->setRoles(array('ROLE_USER'));
        $em->persist($user2);

        $user3 = new User();
        $user3->setUsername("Mr.Beaver");
        $user3->setPassword(password_hash("user", PASSWORD_BCRYPT));
        $user3->setRoles(array('ROLE_USER'));
        $em->persist($user3);

        $em->flush();
        $output->writeln("Terminé.");

        /*Ajout de projets*/

        $output->writeln("Ajout de projets ...");
        $projectsNames=array("Bateau en or","Fusée à eau","Ordinateur à pédale","Plateforme collaborative de partage de projets");
        $projectsDescription=array(
            "Création d'un bateau en or, avec des attributs uniques aux mondes",
            "La fusée à eau sera révolutionnaire, fini le gaspillage du pétrole !",
            "L'ordinateur à pédale vous permet d'utiliser votre PC sans surconsommer !",
            "Avec cette plateforme collaborative, vous pourrez trouver des personnes avec qui réaliser vos projets!",
        );
        $topics=array();
        for ($i=0; $i <count($projectsNames) ; $i++) { 
            $topic = new Topic();
            $topic->setTitle($projectsNames[$i]);
            $topic->setDescription($projectsDescription[$i]);
            $topic->setUser($user2);
            $topic->setDateheure(new \DateTime('2018/03/25'));
            $em->persist($topic);
            array_push($topics,$topic);
        }
         $output->writeln("Terminé.");
        $em->flush();

        $topics[0] = $user->voteForTopic($topics[0]);
        $topics[0] = $user2->voteForTopic($topics[0]);
        $topics[0] = $user3->voteForTopic($topics[0]);
        $em->merge($user);
        $em->merge($user2);
        $em->merge($user3);
        $em->merge($topics[0]);


        /*Ajout de messages*/
        $messages=array(
            array(
                "message"=>"Je peux aider pour les fonds, si besoin.",
                "user"=>$user,
                "topic"=>$topics[0],
            ),
             array(
                "message"=>"Moi j'ai peu d'argent, mais je m'y connais en fonderie.",
                "user"=>$user3,
                "topic"=>$topics[0],
            ),
              array(
                "message"=>"Vive la planète",
                "user"=>$user2,
                "topic"=>$topics[1],
            ),
               array(
                "message"=>"Pensez à vérifier si ça n'a pas déjà été fait",
                "user"=>$user,
                "topic"=>$topics[3],
            ),
        );

        foreach ($messages as $message) {
            $messageNew = new Message();
            $messageNew->setUser($message["user"]);
            $messageNew->setTopic($message["topic"]);
            $messageNew->setContent($message["message"]);
            $em->persist($messageNew);
        }
          $output->writeln("Terminé.");

     
        $em->flush();

    }

}
