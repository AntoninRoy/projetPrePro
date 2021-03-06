<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\MessageRepository")
 */
class Message
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
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     */
    private $voters;

    /**
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Message",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $replyMessage;

    /**
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Topic",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $topic;


    public function __construct()
    {
        $this->voters = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set content.
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get nbVote.
     *
     * @return int
     */
    public function getNbVote()
    {
        return sizeof($this->voters);
    }


    /**
     * Set user.
     *
     * @param \ForumBundle\Entity\User $user
     *
     * @return Message
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

    /**
     * Set replyMessage.
     *
     * @param \ForumBundle\Entity\Message $replyMessage
     *
     * @return Message
     */
    public function setReplyMessage(\ForumBundle\Entity\Message $replyMessage)
    {
        $this->replyMessage = $replyMessage;

        return $this;
    }

    /**
     * Get replyMessage.
     *
     * @return \ForumBundle\Entity\Message
     */
    public function getReplyMessage()
    {
        return $this->replyMessage;
    }

    /**
     * Set topic.
     *
     * @param \ForumBundle\Entity\Topic $topic
     *
     * @return Message
     */
    public function setTopic(\ForumBundle\Entity\Topic $topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic.
     *
     * @return \ForumBundle\Entity\Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Add voter.
     *
     * @param \ForumBundle\Entity\User $voter
     *
     * @return Message
     */
    public function addVoter(\ForumBundle\Entity\User $voter)
    {
        $this->voters[] = $voter;

        return $this;
    }

    /**
     * Remove voter.
     *
     * @param \ForumBundle\Entity\User $voter
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeVoter(\ForumBundle\Entity\User $voter)
    {
        return $this->voters->removeElement($voter);
    }

    /**
     * Get voters.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVoters()
    {
        return $this->voters;
    }
}
