<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    function __construct()
    {
        parent::__construct();
    }
    /**
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\News", mappedBy="author", cascade={"remove"})
     */
    private $news;
    /**
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Forum", mappedBy="author", cascade={"remove"})
     */
    private $message;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

