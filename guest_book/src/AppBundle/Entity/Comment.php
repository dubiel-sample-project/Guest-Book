<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment extends AbstractEntry
{
    /**
     * @var Entry
     *
     * @ORM\ManyToOne(
     *  targetEntity="Entry",
     *  inversedBy="comments"
     * )
     *
     * @ORM\JoinColumn(name="entry_id", referencedColumnName="id", nullable=true)
     */
    protected $entry;

    /**
     * @return int
     */
    public function getType()
    {
        return self::TYPE_COMMENT;
    }

    /**
     * @return Entry
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param Entry $entry
     * @return Comment
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;
        return $this;
    }
}

