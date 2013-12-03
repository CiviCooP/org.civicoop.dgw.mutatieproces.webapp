<?php

namespace CiviCoop\VragenboomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CiviCoop\VragenboomBundle\Entity\AdviesRapport;
use CiviCoop\VragenboomBundle\Entity\AdviesRapportRegel;
use CiviCoop\VragenboomBundle\Form\AdviesRapportType;
use CiviCoop\VragenboomBundle\Form\AdviesRapportRegelType;

/**
 * AdviesRapport controller.
 *
 * @Route("/adviesrapport")
 */
class AdviesRapportController extends AbstractController
{

    /**
     * Lists all AdviesRapport entities.
     *
     * @Route("/", name="adviesrapport")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {	
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CiviCoopVragenboomBundle:AdviesRapport')->findAllActive();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a AdviesRapport entity.
     *
     * @Route("/{id}", name="adviesrapport_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CiviCoopVragenboomBundle:AdviesRapport')->findOneById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdviesRapport entity.');
        }
		
		$editForm = $this->createForm(new AdviesRapportType(), $entity);
		
        return array(
            'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing AdviesRapport entity.
     *
     * @Route("/{id}/update", name="adviesrapport_update")
     * @Method("PUT")
     * @Template("CiviCoopVragenboomBundle:AdviesRapport:show.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CiviCoopVragenboomBundle:AdviesRapport')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AdviesRapport entity.');
        }

        $editForm = $this->createForm(new AdviesRapportType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('adviesrapport_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
			'regel_form'  => $regel_form->createView(),
        );
    }
	
}
