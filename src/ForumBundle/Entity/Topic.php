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
}
