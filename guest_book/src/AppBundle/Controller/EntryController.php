<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Entry;
use AppBundle\Form\EntryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Entry controller.
 *
 * @Route("entry")
 */
class EntryController extends Controller
{
    /**
     * Lists all entry entities.
     *
     * @Route("/", name="entry_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        /* @var $entryRepo EntryRepository */
        $entryRepo = $this->get('app.repository.entry');	
		
		$query = $entryRepo->findAll();

        return $this->render(
            '@App/entry/index.html.twig',
            array(
				'pagination'  => 
					$this->get('app.paginator_aware')->getPagination($query, $request->query->getInt('page', 1))
			)
        );		
    }

    /**
     * Creates a new entry entity.
     *
     * @Route("/new", name="entry_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entry = new Entry();
        $form = $this->createForm('AppBundle\Form\EntryType', $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entry);
            $em->flush($entry);

            return $this->redirectToRoute('entry_show', array('id' => $entry->getId()));
        }

        return $this->render('@App/entry/new.html.twig', array(
            'entry' => $entry,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a entry entity.
     *
     * @Route("/{id}", name="entry_show")
     * @Method("GET")
     */
    public function showAction(Entry $entry)
    {
        $deleteForm = $this->createDeleteForm($entry);

        return $this->render('@App/entry/show.html.twig', array(
            'entry' => $entry,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing entry entity.
     *
     * @Route("/{id}/edit", name="entry_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Entry $entry)
    {
        $deleteForm = $this->createDeleteForm($entry);
        $editForm = $this->createForm(EntryType::class, $entry);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entry_show', array('id' => $entry->getId()));
        }

        return $this->render('@App/entry/edit.html.twig', array(
            'entry' => $entry,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a entry entity.
     *
     * @Route("/{id}", name="entry_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Entry $entry)
    {
        $form = $this->createDeleteForm($entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entry);
            $em->flush($entry);
        }

        return $this->redirectToRoute('entry_index');
    }

    /**
     * Creates a form to delete a entry entity.
     *
     * @param Entry $entry The entry entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Entry $entry)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entry_delete', array('id' => $entry->getId())))
            ->add('submit', SubmitType::class, array(
                'label' => 'Delete'
            ))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
