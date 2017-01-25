<?php

namespace AppBundle\Controller;

use AppBundle\Form\SearchType;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Route("/search/{searchTerm}/", name="index_search", defaults={"searchTerm": null})
     * @param Request $request
     * @param string $searchTerm
     *
     * @Template()
     */
    public function indexAction(Request $request, $searchTerm = null)
    {
        /* @var $entryRepo EntityRepository */
        $entryRepo = $this->get('app.repository.entry');

        $query = $searchTerm ? $entryRepo->findEntriesByQuery($searchTerm)
            : $entryRepo->getLatestEntries();

        $paginator = $this->get('knp_paginator')->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render(
            'AppBundle:default:index.html.twig',
            array(
				'pagination'  => $paginator
			)
        );
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('index_search', array(
                'searchTerm' => $form->get('query')->getData()
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
