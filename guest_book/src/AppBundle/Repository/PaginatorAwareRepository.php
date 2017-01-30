<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAware;

class PaginatorAwareRepository extends PaginatorAware 
{
    /**
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */	
	public function getPagination(Query $query, $page, $limit = 10)
	{
		return $this->getPaginator()->paginate(
            $query,
            $page,
            $limit
        );		
	}
}