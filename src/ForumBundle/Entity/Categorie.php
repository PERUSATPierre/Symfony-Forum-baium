<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\CategorieRepository")
 */
class Categorie
{
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->type = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Forum", mappedBy="categorie", cascade={"remove"})
     */
    private $type;
    /**
     * @ORM\Column(name="title", type="string")
     */
    private $title;
    /**
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add type
     *
     * @param \ForumBundle\Entity\Forum $type
     *
     * @return Categorie
     */
    public function addType(\ForumBundle\Entity\Forum $type)
    {
        $this->type[] = $type;

        return $this;
    }

    /**
     * Remove type
     *
     * @param \ForumBundle\Entity\Forum $type
     */
    public function removeType(\ForumBundle\Entity\Forum $type)
    {
        $this->type->removeElement($type);
    }

    /**
     * Get type
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Categorie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Categorie
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}