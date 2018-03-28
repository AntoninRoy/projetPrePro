<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Topic
 *
 * @ORM\Table(name="topic")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\TopicRepository")
 */
class Topic
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=2000, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     */
    private $voters;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateheure;

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
     * Set title.
     *
     * @param string $title
     *
     * @return Topic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Topic
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user.
     *
     * @param \ForumBundle\Entity\User $user
     *
     * @return Topic
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
     * Add voter.
     *
     * @param \ForumBundle\Entity\User $voter
     *
     * @return Topic
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

    /**
     * Get nbVote.
     *
     * @return int
     */
    public function getNbVotes()
    {
        return sizeof($this->voters);
    }

    /**
     * Set dateheure.
     *
     * @param \DateTime $dateheure
     *
     * @return Topic
     */
    public function setDateheure($dateheure)
    {
        $this->dateheure = $dateheure;

        return $this;
    }

    /**
     * Get dateheure.
     *
     * @return \DateTime
     */
    public function getDateheure()
    {
        return $this->dateheure;
    }
}
