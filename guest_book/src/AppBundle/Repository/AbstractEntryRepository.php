<?php

namespace AppBundle\Repository;

class AbstractEntryRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return \Doctrine\ORM\Query
     */
    public function findAll()
    {
        return $this->createQueryBuilder('a')->getQuery();
    }
}