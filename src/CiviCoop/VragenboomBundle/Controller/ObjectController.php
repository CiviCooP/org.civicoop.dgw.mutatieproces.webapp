<?php

namespace CiviCoop\VragenboomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CiviCoop\VragenboomBundle\Entity\Object;
use CiviCoop\VragenboomBundle\Form\ObjectType;

/**
 * Object controller.
 *
 * @Route("/ruimtes/{ruimte}")
 */
class ObjectController extends AbstractController {

  /**
   * Lists all Object entities.
   *
   * @Route("/", name="objects")
   * @Method("GET")
   * @Template()
   */
  public function indexAction($ruimte) {
    $ruimte = $this->getRuimte($ruimte);
    return array(
      'entities' => $ruimte->getObjects(),
      'ruimte' => $ruimte,
    );
  }

  /**
   * Creates a new Object entity.
   *
   * @Route("/", name="objects_create")
   * @Method("POST")
   * @Template("CiviCoopVragenboomBundle:Object:new.html.twig")
   */
  public function createAction(Request $request, $ruimte) {
    $ruimte = $this->getRuimte($ruimte);

    $entity = new Object();
    $entity->addRuimte($ruimte);
    $form = $this->createForm(new ObjectType(), $entity);
    $form->bind($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('objects', array('ruimte' => $ruimte->getSlug())));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
      'ruimte' => $ruimte,
    );
  }

  /**
   * Displays a form to create a new Object entity.
   *
   * @Route("/new", name="objects_new")
   * @Method("GET")
   * @Template()
   */
  public function newAction($ruimte) {
    $ruimte = $this->getRuimte($ruimte);
    $entity = new Object();
    $entity->addRuimte($ruimte);
    $form = $this->createForm(new ObjectType(), $entity);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
      'ruimte' => $ruimte,
    );
  }

  /**
   * Finds and displays a Object entity.
   *
   * @Route("/{object}", name="objects_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction($ruimte, $object) {
    $ruimte = $this->getRuimte($ruimte);
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('CiviCoopVragenboomBundle:Object')->findOneBySlug($object);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Object entity.');
    }

    $deleteForm = $this->createDeleteForm($object);

    return array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
      'ruimte' => $ruimte,
    );
  }

  /**
   * Displays a form to edit an existing Object entity.
   *
   * @Route("/{object}/edit", name="objects_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction($ruimte, $object) {
    $ruimte = $this->getRuimte($ruimte);
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('CiviCoopVragenboomBundle:Object')->findOneBySlug($object);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Object entity.');
    }

    $editForm = $this->createForm(new ObjectType(), $entity);
    $deleteForm = $this->createDeleteForm($object);

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
      'ruimte' => $ruimte,
    );
  }

  /**
   * Edits an existing Object entity.
   *
   * @Route("/{object}", name="objects_update")
   * @Method("PUT")
   * @Template("CiviCoopVragenboomBundle:Object:edit.html.twig")
   */
  public function updateAction(Request $request, $ruimte, $object) {
    $ruimte = $this->getRuimte($ruimte);
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('CiviCoopVragenboomBundle:Object')->findOneBySlug($object);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Object entity.');
    }

    $deleteForm = $this->createDeleteForm($object);
    $editForm = $this->createForm(new ObjectType(), $entity);
    $editForm->bind($request);

    if ($editForm->isValid()) {
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('objects', array('ruimte' => $ruimte->getSlug())));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
      'ruimte' => $ruimte,
    );
  }

  /**
   * Deletes a Object entity.
   *
   * @Route("/{object}", name="objects_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $ruimte, $object) {
    $ruimte = $this->getRuimte($ruimte);
    $form = $this->createDeleteForm($object);
    $form->bind($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('CiviCoopVragenboomBundle:Object')->findOneBySlug($object);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Object entity.');
      }
      
      foreach ($entity->getActies() as $actie) {
        $em->remove($actie);
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('objects', array('ruimte' => $ruimte->getSlug())));
  }

  /**
   * Creates a form to delete a Object entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($object) {
    return $this->createFormBuilder(array('object' => $object))
            ->add('object', 'hidden')
            ->getForm()
    ;
  }

}
