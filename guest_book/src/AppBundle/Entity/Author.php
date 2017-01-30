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
     *  targetEntity="AbstractEntry",
     *  mappedBy="author"
     * )
     */
    private $abstractEntries;

    public function __construct()
    {
        parent::__construct();

        $this->abstractEntries = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return AbstractEntry[]|Collection
     */
    public function getAbstractEntries()
    {
        return $this->abstractEntries;
    }

    /**
     * @param AbstractEntry[]|Collection $entries
     * @return Author
     */
    public function setAbstractEntries($entries)
    {
        $this->abstractEntries = $entries;
        return $this;
    }

    /**
     * @return Entry[]|array|ArrayCollection|Collection
     */
    public function getEntries()
    {
        return array_filter($this->abstractEntries->toArray(), function(AbstractEntry $entry) {
            $entry->getType() == AbstractEntry::TYPE_ENTRY;
        });
    }

    /**
     * @return Entry[]|array|ArrayCollection|Collection
     */
    public function getComments()
    {
        return array_filter($this->abstractEntries->toArray(), function(AbstractEntry $entry) {
            $entry->getType() == AbstractEntry::TYPE_COMMENT;
        });
    }
}