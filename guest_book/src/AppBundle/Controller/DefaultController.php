<?php

namespace AppBundle\Controller;

use AppBundle\Form\SearchType;
use AppBundle\Repository\EntryRepository;
use AppBundle\Repository\PaginatorAwareRepository;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Route("/index/{searchTerm}/", name="index_search", defaults={"searchTerm": null})
	 *
     * @param Request $request
     * @param string $searchTerm
     *
     */
    public function indexAction(Request $request, $searchTerm = null)
    {
        /* @var $entryRepo EntryRepository */
        $entryRepo = $this->get('app.repository.entry');

        $query = $searchTerm ? $entryRepo->findEntriesByQuery($searchTerm)
            : $entryRepo->getLatestEntries();

        return $this->render(
            'AppBundle:default:index.html.twig',
            array(
				'pagination'  => 
					$this->get('app.paginator_aware')->getPagination($query, $request->query->getInt('page', 1)),
				'search_term' => $searchTerm
			)
        );
    }

    /**
     * @Route("/search", name="search", defaults={"searchTerm": null} )
	 *
     * @param Request $request
     * @param string $searchTerm
     */
    public function searchAction(Request $request, $searchTerm = null)
    {
        $form = $this->createForm(SearchType::class, null, array(
            'value' => $searchTerm
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
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
