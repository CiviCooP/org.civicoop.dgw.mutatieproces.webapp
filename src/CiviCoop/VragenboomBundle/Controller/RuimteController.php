<?php

namespace CiviCoop\VragenboomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CiviCoop\VragenboomBundle\Entity\Ruimte;
use CiviCoop\VragenboomBundle\Form\RuimteType;

/**
 * Ruimte controller.
 *
 * @Route("/ruimtes")
 */
class RuimteController extends Controller
{

    /**
     * Lists all Ruimte entities.
     *
     * @Route("/", name="ruimtes")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CiviCoopVragenboomBundle:Ruimte')->findAllOrderByNaam();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Ruimte entity.
     *
     * @Route("/", name="ruimtes_create")
     * @Method("POST")
     * @Template("CiviCoopVragenboomBundle:Ruimte:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Ruimte();
        $form = $this->createForm(new RuimteType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ruimtes'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Ruimte entity.
     *
     * @Route("/new", name="ruimtes_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ruimte();
        $form   = $this->createForm(new RuimteType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ruimte entity.
     *
     * @Route("/{ruimte}/edit", name="ruimtes_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($ruimte)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CiviCoopVragenboomBundle:Ruimte')->findOneBySlug($ruimte);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ruimte entity.');
        }

        $editForm = $this->createForm(new RuimteType(), $entity);
        $deleteForm = $this->createDeleteForm($ruimte);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Ruimte entity.
     *
     * @Route("/{ruimte}", name="ruimtes_update")
     * @Method("PUT")
     * @Template("CiviCoopVragenboomBundle:Ruimte:edit.html.twig")
     */
    public function updateAction(Request $request, $ruimte)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CiviCoopVragenboomBundle:Ruimte')->findOneBySlug($ruimte);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ruimte entity.');
        }

        $deleteForm = $this->createDeleteForm($ruimte);
        $editForm = $this->createForm(new RuimteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ruimtes'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Ruimte entity.
     *
     * @Route("/{ruimte}", name="ruimtes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $ruimte)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CiviCoopVragenboomBundle:Ruimte')->findOneBySlug($ruimte);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ruimte entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ruimtes'));
    }

    /**
     * Creates a form to delete a Ruimte entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($ruimte)
    {
        return $this->createFormBuilder(array('ruimte' => $ruimte))
            ->add('ruimte', 'hidden')
            ->getForm()
        ;
    }
}
