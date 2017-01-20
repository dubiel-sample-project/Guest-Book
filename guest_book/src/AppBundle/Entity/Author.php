<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as FOSUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="author")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AuthorRepository")
 */
class Author extends FOSUser
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
     *  targetEntity="Entry",
     *  mappedBy="author"
     * )
     */
    protected $entries;

    /**
     * @var Comment[]|Collection
     *
     * @ORM\OneToMany(
     *  targetEntity="Comment",
     *  mappedBy="author"
     * )
     */
    protected $comments;

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