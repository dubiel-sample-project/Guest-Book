<?php

namespace AppBundle\Repository;

/**
 * EntryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EntryRepository extends \Doctrine\ORM\EntityRepository
{
	public function findEntriesByQuery($query)
	{
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT e FROM AppBundle:Entry e WHERE e.content LIKE '%$query%' ORDER BY e.updatedAt DESC";
        return $em->createQuery($dql);		
	}
	
	public function getLatestEntries()
	{
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT e FROM AppBundle:Entry e ORDER BY e.updatedAt DESC";
        return $em->createQuery($dql);
	}
}
