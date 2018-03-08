<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Forum
 *
 * @ORM\Table(name="forum")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\ForumRepository")
 */
class Forum
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
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Categorie", inversedBy="type")
     */
    private $categorie;
    /**
     * @ORM\Column(type="date")
     */
    private $date;
    /**
     * @ORM\Column(type="text", length=30000)
     */
    private $message;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="message")
     */
    private $author;
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
     * Set categorie
     *
     * @param \ForumBundle\Entity\Categorie $categorie
     *
     * @return Forum
     */
    public function setCategorie(\ForumBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \ForumBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

}
