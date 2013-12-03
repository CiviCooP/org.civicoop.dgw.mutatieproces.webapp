<?php

namespace CiviCoop\VragenboomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CiviCoop\VragenboomBundle\Entity\ActieDefinitie;
use CiviCoop\VragenboomBundle\Form\ActieDefinitieType;

/**
 * ActieDefinitie controller.
 *
 * @Route("/ruimtes/{ruimte}/{object}")
 */
class ActieDefinitieController extends AbstractController
{

    /**
     * Lists all ActieDefinitie entities.
     *
     * @Route("/", name="actiedefinitie")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($ruimte, $object)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CiviCoopVragenboomBundle:ActieDefinitie')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ActieDefinitie entity.
     *
     * @Route("/", name="actiedefinitie_create")
     * @Method("POST")
     * @Template("CiviCoopVragenboomBundle:ActieDefinitie:new.html.twig")
     */
    public function createAction(Request $request, $ruimte, $object)
    {
		$ruimte = $this->getRuimte($ruimte);
		$object = $this->getObject($object);
		
		$type = $this->getType();
        $entity  = new ActieDefinitie();
		$entity->setType($type);
		$entity->setObject($object);
		
        $form = $this->createForm(new ActieDefinitieType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('objects', array('ruimte' => $ruimte->getSlug())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'ruimte' => $ruimte,
			'object' => $object,
        );
    }

    /**
     * Displays a form to create a new ActieDefinitie entity.
     *
     * @Route("/new", name="actiedefinitie_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($ruimte, $object)
    {
		$ruimte = $this->getRuimte($ruimte);
		$object = $this->getObject($object);
		$type = $this->getType();
        $entity = new ActieDefinitie();
		$entity->setType($type);
		$entity->setObject($object);
        $form   = $this->createForm(new ActieDefinitieType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'ruimte' => $ruimte,
			'object' => $object,
        );
    }

    /**
     * Finds and displays a ActieDefinitie entity.
     *
     * @Route("/{id}", name="actiedefinitie_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($ruimte, $object, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CiviCoopVragenboomBundle:ActieDefinitie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActieDefinitie entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
			'ruimte' => $ruimte,
			'object' => $object,
        );
    }

    /**
     * Displays a form to edit an existing ActieDefinitie entity.
     *
     * @Route("/{id}/edit", name="actiedefinitie_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($ruimte, $object, $id)
    {
		$ruimte = $this->getRuimte($ruimte);
		$object = $this->getObject($object);
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CiviCoopVragenboomBundle:ActieDefinitie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActieDefinitie entity.');
        }

        $editForm = $this->createForm(new ActieDefinitieType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
			'ruimte' => $ruimte,
			'object' => $object,
        );
    }

    /**
     * Edits an existing ActieDefinitie entity.
     *
     * @Route("/{id}", name="actiedefinitie_update")
     * @Method("PUT")
     * @Template("CiviCoopVragenboomBundle:ActieDefinitie:edit.html.twig")
     */
    public function updateAction(Request $request, $ruimte, $object, $id)
    {
		$ruimte = $this->getRuimte($ruimte);
		$object = $this->getObject($object);
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CiviCoopVragenboomBundle:ActieDefinitie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ActieDefinitie entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ActieDefinitieType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('objects', array('ruimte' => $ruimte->getSlug())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
			'ruimte' => $ruimte,
			'object' => $object,
        );
    }
    /**
     * Deletes a ActieDefinitie entity.
     *
     * @Route("/{id}", name="actiedefinitie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $ruimte, $object, $id)
    {
		$ruimte = $this->getRuimte($ruimte);
		$object = $this->getObject($object);
		
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CiviCoopVragenboomBundle:ActieDefinitie')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ActieDefinitie entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('objects', array('ruimte' => $ruimte->getSlug())));
    }

    /**
     * Creates a form to delete a ActieDefinitie entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
