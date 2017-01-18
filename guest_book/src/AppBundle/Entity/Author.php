<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @package AppBundle\Entity
 */
class Author extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    protected $id;

    /**
     * @var Entry[]|Collection
     *
     * @ORM\OneToMany(
     *  targetEntity="AppBundle\Entity\Entry",
     *  mappedBy="author"
     * )
     */
    private $entries;

    /**
     * @var Comment[]|Collection
     *
     * @ORM\OneToMany(
     *  targetEntity="AppBundle\Entity\Comment",
     *  mappedBy="author"
     * )
     */
    private $comments;

    public function __construct()
    {
        parent::__construct();

        $this->entries = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Entry[]|Collection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param Entry[]|Collection $entries
     * @return Author
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;
        return $this;
    }

    /**
     * @return Comment[]|Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment[]|Collection $comments
     * @return Author
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

}