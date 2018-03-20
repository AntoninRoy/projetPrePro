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

        $em->flush();
        $output->writeln("Terminé.");

        /*Ajout de projets*/

        $output->writeln("Ajout de projets ...");
        $projectsNames=array("Bateau en or","Fusée à eau","Ordinateur à pédale","Shampoing pour chauve");
        $projectsDescription=array(
            "Création d'un bateau en or, avec des attributs uniques aux mondes",
            "La fusée à eau sera révolutionnaire, fini le gaspillage du pétrole, mainteant c'est le gaspillage de l'eau",
            "L'ordinateur à pédale permet aux gros flemmards d'être contraints à faire du sport",
            "Le shampoing pour chauve sera le moins cher du marché et le plus écologique, en effet il sera fait avec seulement de l'air.",
        );
        $topics=array();
        for ($i=0; $i <count($projectsNames) ; $i++) { 
            $topic = new Topic();
            $topic->setTitle($projectsNames[$i]);
            $topic->setDescription($projectsDescription[$i]);
            $topic->setUser($user2);
            $em->persist($topic);
            array_push($topics,$topic);
        }
         $output->writeln("Terminé.");

     
        $em->flush();

        /*Ajout de messages*/
        $messages=array(
            array(
                "message"=>"J'ai plein de tunes je peux aider.",
                "user"=>$user2,
                "topic"=>$topics[0],
            ),
             array(
                "message"=>"Moi j'ai pas de tunes mais j'ai plein d'amour.",
                "user"=>$user2,
                "topic"=>$topics[0],
            ),
            array(
                "message"=>"Ta gueule",
                "user"=>$user2,
                "topic"=>$topics[0],
            ),
              array(
                "message"=>"Vive la planète",
                "user"=>$user2,
                "topic"=>$topics[1],
            ),
               array(
                "message"=>"T tro con lé chove y ont pas de CheVe",
                "user"=>$user2,
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
