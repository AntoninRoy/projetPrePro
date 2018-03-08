<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Report
 *
 * @ORM\Table(name="report")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\ReportRepository")
 */
class Report
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
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Message",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


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
     * Set message.
     *
     * @param \ForumBundle\Entity\Message $message
     *
     * @return Report
     */
    public function setMessage(\ForumBundle\Entity\Message $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return \ForumBundle\Entity\Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set user.
     *
     * @param \ForumBundle\Entity\User $user
     *
     * @return Report
     */
    public function setUser(\ForumBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \ForumBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
