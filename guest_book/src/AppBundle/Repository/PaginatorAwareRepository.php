<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;
use Knp\Component\Pager\Paginator\PaginatorAware;

class PaginatorAwareRepository extends PaginatorAware 
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */	
	public function getPaginator(Query $query, $page, $limit = 10) 
	{
		return $this->getPaginator()->paginate(
            $query,
            $page,
            $limit
        );		
	}
}