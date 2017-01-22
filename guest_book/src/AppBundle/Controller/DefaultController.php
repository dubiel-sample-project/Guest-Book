<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SearchType as SearchForm;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
		$entryRepo = $this->get('doctrine.orm.entryrepository');
		
		$query = $request->has('query') ?
			$entryRepo->findEntriesByQuery($request->get('query'))
			:
			$entryRepo->getLatestEntries()
		;

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );	
		
        return $this->render(
            'AppBundle:default:index.html.twig',
            array(
				'pagination'  => $pagination,
				'search_form' => (new SearchForm())->getView();
			)
        );
    }
}
