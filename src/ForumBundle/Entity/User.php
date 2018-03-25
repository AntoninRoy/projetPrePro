<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\UserRepository")
 * @UniqueEntity("username",  message = "Un utilisateur possède déjà ce pseudo.")
 */
class User implements UserInterface

{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
        /**
       * @ORM\Column(name="username", type="string", length=255, unique=true)
       */
      private $username;

      /**
       * @ORM\Column(name="password", type="string", length=255)
       */
      private $password;

      /**
       * @ORM\Column(name="salt", type="string", length=255,nullable=true)
       */
      private $salt;

      /**
       * @ORM\Column(name="roles", type="array")
       */
      private $roles = array();

      /**
         * @Assert\NotBlank()
         * @Assert\Length(max=4096)
         */
        private $plainPassword;

    /**
     * @ORM\ManyToMany(targetEntity="Message")
     */
    private $votedMessages;


  // Les getters et setters

  public function eraseCredentials()
  {
  }
  public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
        $this->roles = array('ROLE_USER');

        $this->votedMessages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return $this->roles;
    }
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set salt.
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set roles.
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function hasVoted(\ForumBundle\Entity\Message $message)
    {
        return ($this->votedMessages)->contains($message);
    }

    public function voteFor(\ForumBundle\Entity\Message $message)
    {
        if($this->hasVoted($message))
        {
            $this->removeVotedMessage($message);
            $message->removeVoter($this);
        }
        else
        {
            $this->addVotedMessage($message);
            $message->addVoter($this);
        }
        return $message;
    }

    /**
     * Add votedMessage.
     *
     * @param \ForumBundle\Entity\Message $votedMessage
     *
     * @return User
     */
    public function addVotedMessage(\ForumBundle\Entity\Message $votedMessage)
    {
        $this->votedMessages[] = $votedMessage;

        return $this;
    }

    /**
     * Remove votedMessage.
     *
     * @param \ForumBundle\Entity\Message $votedMessage
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeVotedMessage(\ForumBundle\Entity\Message $votedMessage)
    {
        return $this->votedMessages->removeElement($votedMessage);
    }

    /**
     * Get votedMessages.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVotedMessages()
    {
        return $this->votedMessages;
    }
}
