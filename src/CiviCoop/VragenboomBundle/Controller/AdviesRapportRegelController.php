<?php

namespace CiviCoop\VragenboomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CiviCoop\VragenboomBundle\Entity\Factory\RapportFactory;
use CiviCoop\VragenboomBundle\Entity\AdviesRapportRegel;
use CiviCoop\VragenboomBundle\Entity\EindRapportRegel;
use CiviCoop\VragenboomBundle\Entity\AdviesRapport;
use CiviCoop\VragenboomBundle\Form\AdviesRapportFactoryType;
use CiviCoop\VragenboomBundle\Form\EditAdviesRapportRegelType;

/**
 * AdviesRapportRegel controller.
 *
 * @Route("/adviesrapport/{shortname}/{id}")
 */
class AdviesRapportRegelController extends Controller {

  /**
   * Displays a form to create a new AdviesRapportRegel entity.
   *
   * @Route("/new", name="adviesrapportregel_new")
   * @Method({"GET", "POST"})
   * @Template()
   */
  public function newAction(Request $request, $id, $shortname) {
    $em = $this->getDoctrine()->getManager();
    $factory = $this->get('civicoop.vragenboom.rapportfactory');

    $rapport = $em->getRepository($factory->getEntityFromShortname($shortname))->findOneById($id);   
    
    //get the last used room from session
    $session  = $this->get("session");
    
    $form = $this->createForm(new AdviesRapportFactoryType());
    $ruimte_id = $session->get("room-".$id, false);
    if ($ruimte_id) {
      $ruimte = $em->getRepository("CiviCoopVragenboomBundle:Ruimte")->findOneById($ruimte_id);
      $form->get('ruimte')->setData($ruimte);
    }
    
    if ($request->isMethod('POST')) {
      $form->bind($request);

      if ($form->isValid()) {
        $ruimte = $form->get('ruimte')->getData();

        foreach($form->get('acties')->getData() as $actie) {
          $rapportFactory = new RapportFactory();
          $rapportFactory->setRuimte($ruimte);
          $rapportFactory->setObject($actie->getObject());
          $rapportFactory->setActie($actie);

          $regel = $rapportFactory->make($rapport);
          $em->persist($regel);
        }

        $em->flush();


        //save ruimte in session 
        if ($ruimte) {
          $session->set("room-".$id, $ruimte->getId());
        }

        if ($request->request->get('add_another_rule')) {
          return $this->redirect($this->generateUrl('adviesrapportregel_new', array('shortname' => $factory->getShortName($rapport), 'id' => $rapport->getId())));
        }
        return $this->redirect($this->generateUrl('adviesrapport_show', array('shortname' => $factory->getShortName($rapport), 'id' => $rapport->getId())));
      }
    }
    
    return array(
      'form' => $form->createView(),
      'rapport' => $rapport,
      'factory' => $factory,
    );
  }
  
  /**
   * Update an existing AdviesRapportRegel entity.
   *
   * @Route("/update/{rule_id}", name="adviesrapportregel_update")
   * @Method("POST")
   * @Template("CiviCoopVragenboomBundle:AdviesRapportRegel:edit.html.twig")
   */
  public function updateAction(Request $request, $shortname, $id, $rule_id) {
    $em = $this->getDoctrine()->getManager();
    $factory = $this->get('civicoop.vragenboom.rapportfactory');

    $rapport = $em->getRepository($factory->getEntityFromShortname($shortname))->findOneById($id);
    $entity = false;
    foreach($rapport->getRegels() as $r) {
      if ($r->getId() == $rule_id) {
        $entity = $r;
        break;
      }
    }
    
    if (!$entity) {
      throw $this->createNotFoundException();
    }

    $form = $this->createForm(new EditAdviesRapportRegelType(), $entity);
    $form->bind($request);

    if ($form->isValid()) {
      $em->persist($entity);
      $em->flush();
      $ruimte = $entity->getRuimte();
            
      return $this->redirect($this->generateUrl('adviesrapport_show', array('shortname' => $factory->getShortName($rapport), 'id' => $rapport->getId())));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
      'rapport' => $rapport,
    );
  }

  /**
   * Displays a form to edit an exiting AdviesRapportRegel entity.
   *
   * @Route("/edit/{rule_id}", name="adviesrapportregel_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction($id, $shortname, $rule_id) {
    $em = $this->getDoctrine()->getManager();
    $factory = $this->get('civicoop.vragenboom.rapportfactory');

    $rapport = $em->getRepository($factory->getEntityFromShortname($shortname))->findOneById($id);
    
    $entity = false;
    foreach($rapport->getRegels() as $r) {
      if ($r->getId() == $rule_id) {
        $entity = $r;
        break;
      }
    }
    
    if (!$entity) {
      throw $this->createNotFoundException();
    }
    
    $form = $this->createForm(new EditAdviesRapportRegelType(), $entity);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
      'rapport' => $rapport,
      'factory' => $factory,
    );
  }

  /**
   * @Route("/objects", name="adviesrapportregel_objects")
   */
  public function listObjects($id, Request $request) {
    $this->em = $this->get('doctrine')->getEntityManager();
    $this->repository = $this->em->getRepository('CiviCoopVragenboomBundle:Ruimte');

    $ruimte_id = $this->get('request')->query->get('data');

    $ruimte = $this->repository->findOneById($ruimte_id);

    if (!$ruimte || !$ruimte->getObjects()) {
      return new Response('<option>Geen objecten</option>');
    }
    
    //save ruimte in session 
    if ($ruimte) {
      $session  = $this->get("session");
      $session->set("room-".$id, $ruimte->getId());
    }

    $html = '<option selected="selected" disabled="disabled">Kies een object</option>';
    foreach ($ruimte->getObjects() as $o) {
      $html = $html . sprintf("<option value=\"%d\">%s</option>", $o->getId(), $o->getNaam());
    }

    return new Response($html);
  }

  /**
   * @Route("/acties", name="adviesrapportregel_acties")
   */
  public function listActies() {
    $this->em = $this->get('doctrine')->getEntityManager();
    $this->repository = $this->em->getRepository('CiviCoopVragenboomBundle:ActieDefinitie');

    $id = $this->get('request')->query->get('data');

    $acties = $this->repository->findByObject($id);

    if (empty($acties)) {
      return new Response('<option>Geen acties</option>');
    }

    $html = '<option selected="selected" disabled="disabled">Kies een actie</option>';
    foreach ($acties as $o) {
      $html = $html . sprintf("<option data-description=\"%s\" data-verantwoordelijke=\"%s\" value=\"%d\">%s</option>", $o->getDescription(), $o->getVerantwoordelijke(), $o->getId(), $o->getActie());
    }

    return new Response($html);
  }

  /**
   * Deletes a Regel entity.
   *
   * @Route("/delete/{entity_id}", name="adviesrapportregel_delete")
   * @Method("GET")
   */
  public function deleteAction(Request $request, $shortname, $id, $entity_id) {
    $em = $this->getDoctrine()->getManager();
    $factory = $this->get('civicoop.vragenboom.rapportfactory');

    $rapport = $em->getRepository($factory->getEntityFromShortname($shortname))->findOneById($id);

    $entity = false;
    foreach($rapport->getRegels() as $r) {
      if ($r->getId() == $entity_id) {
        $entity = $r;
        break;
      }
    }

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find AdviesRapportRegel entity.');
    }
    
    if ($entity instanceof EindRapportRegel) {
      $adviesrapport_regel = $entity->getAdviesRapportRegel();
    } else {
      $adviesrapport_regel = $entity;
    }
    
    if ($adviesrapport_regel instanceof AdviesRapportRegel) {
      $eindrapport_regels = $em->getRepository('CiviCoopVragenboomBundle:EindRapportRegel')->findByAdviesRapportRegel($entity);
      foreach($eindrapport_regels as $eindrapport_regel) {
        $em->remove($eindrapport_regel);
      }
    }
    
    $em->remove($entity);
    $em->flush();

    return $this->redirect($this->generateUrl('adviesrapport_show', array('shortname' => $factory->getShortName($rapport), 'id' => $rapport->getid())));
  }

}
