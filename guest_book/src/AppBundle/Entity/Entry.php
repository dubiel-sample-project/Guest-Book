<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entry
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Entry extends AbstractEntry
{
    /**
     * @var Comment[]|Collection
     *
     * @ORM\OneToMany(
     *  targetEntity="Comment",
     *  mappedBy="entry"
     * )
 	 * @ORM\OrderBy({"updatedAt" = "DESC"})
    */
    private $comments;

    /**
     * @return int
     */
    public function getType()
    {
        return AbstractEntry::TYPE_ENTRY;
    }

    public function __construct()
    {
        parent::__construct();
        $this->comments = new ArrayCollection();
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
     * @return Entry
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }
}

