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
     *  mappedBy="entry",
     *  cascade={"persist", "remove"}
     * )
 	 * @ORM\OrderBy({"updatedAt" = "DESC"})
    */
    private $comments;

    /**
     * @var int
     *
     * @ORM\Column(name="number_of_comments", type="integer")
     */
    private $numberOfComments;

    /**
     * @return int
     */
    public function getType()
    {
        return self::TYPE_ENTRY;
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

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
        return $this;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function removeComment(Comment $comment)
    {
        if($this->comments->contains($comment)) {
            $this->comments->remove($comment);
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfComments()
    {
        return $this->numberOfComments;
    }

    /**
     * @param int $numberOfComments
     * @return Entry
     */
    public function setNumberOfComments($numberOfComments)
    {
        $this->numberOfComments = $numberOfComments;
        return $this;
    }

    /**
     * @ORM\PreFlush
     */
    public function preFlush()
    {
        $this->setNumberOfComments(count($this->comments));
    }

}

