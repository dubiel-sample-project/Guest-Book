<?php

namespace AppBundle\Controller;

use AppBundle\Form\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index", defaults={"searchTerm": null})
     * @Route("/{searchTerm}/", name="index_search", defaults={"searchTerm": null})
     * @param Request $request
     * @param string $searchTerm
     *
     * @Template()
     */
    public function indexAction(Request $request, $searchTerm = null)
    {
		$entryRepo = $this->get('app.repository.entry');

        $query = $searchTerm ?
			$entryRepo->findEntriesByQuery($searchTerm) :
			$query = $entryRepo->getLatestEntries();
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
				'pagination'  => $pagination
			)
        );
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$request->attributes->set('query', $form->get('query'));
            return $this->redirectToRoute('index', array(
                'searchTerm' => $form->get('query')
            ));
        }

        return $this->render(
            'AppBundle::search.html.twig',
            array(
                'search_form' => $form->createView()
            )
        );
    }
}
