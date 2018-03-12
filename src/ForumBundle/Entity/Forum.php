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

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Forum
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

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Forum
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set author
     *
     * @param \UserBundle\Entity\User $author
     *
     * @return Forum
     */
    public function setAuthor(\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
