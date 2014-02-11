<?php

namespace CiviCoop\VragenboomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CiviCoop\VragenboomBundle\Entity\AdviesRapport;

/**
 * AdviesRapport controller.
 *
 * @Route("/adviesrapport")
 */
class AdviesRapportController extends AbstractController {

  /**
   * Lists all AdviesRapport entities.
   *
   * @Route("/", name="adviesrapport")
   * @Method("GET")
   * @Template("CiviCoopVragenboomBundle:AdviesRapport:index.html.twig")
   */
  public function indexAction() {
    $factory = $this->get('civicoop.vragenboom.rapportfactory');
    $entities = $factory->findAllCombinedActive();
    
    /*($adviesgesprek = $em->getRepository('CiviCoopVragenboomBundle:AdviesRapport')->findAllActive();
    $eindgesprek = $em->getRepository('CiviCoopVragenboomBundle:EindRapport')->findAllActive();*/

    return array(
      'entities' => $entities,
      'factory' => $factory,
    );
  }
  
  /**
   * Syncs
   *
   * @Route("/sync", name="adviesrapport_sync")
   * @Method("GET")
   */
  public function sync() {
    $civicase = $this->get('civicoop.dgw.mutatieproces.civicase');
		$civicase->sync();
    
    return $this->redirect($this->generateUrl('adviesrapport'));
  }

  /**
   * Finds and displays a AdviesRapport entity.
   *
   * @Route("/{shortname}/{id}", name="adviesrapport_show")
   * @Method("GET")
   * @Template("CiviCoopVragenboomBundle:AdviesRapport:show.html.twig")
   */
  public function showAction($shortname, $id) {
    $em = $this->getDoctrine()->getManager();
    $factory = $this->get('civicoop.vragenboom.rapportfactory');
    
    $entity = $em->getRepository($factory->getEntityFromShortname($shortname))->findOneById($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Rapport entity.');
    }
    
    $showStatus = false;
    if ($factory->getEntity($entity) == 'CiviCoopVragenboomBundle:EindRapport') {
      //do loading from other reports
     $this->loadEindGesprekRapport($entity);
     $showStatus = true;
    }

    $editForm = $this->createForm($factory->getNewForm($factory->getEntity($entity)), $entity);

    return array(
      'entity' => $entity,
      'factory' => $factory,
      'edit_form' => $editForm->createView(),
      'showStatus' => $showStatus,
    );
  }
  
  protected function loadEindGesprekRapport($rapport) {
    $em = $this->getDoctrine()->getManager();
    $factory = $this->get('civicoop.vragenboom.rapportfactory');
    $reports = $em->getRepository($factory->getEntityFromShortname('adviesrapport'))->findByCaseId($rapport->getCaseId());
    foreach($reports as $rep) {
      foreach($rep->getRegels() as $regel) {
        $contains = false;
        foreach($rapport->getRegels() as $rregel) {
          if ($rregel->getAdviesRapportRegel() && $rregel->getAdviesRapportRegel() == $regel) {
            $contains = true;
            break;
          }
        }
        
        if (!$contains) {
          $eind_regel = new \CiviCoop\VragenboomBundle\Entity\EindRapportRegel();
          $eind_regel->setAdviesRapportRegel($regel);
          $eind_regel->setEindRapport($rapport);
          $rapport->addRegel($eind_regel);
          $em->persist($eind_regel);
        }
      }
    }
    
    $em->persist($rapport);
    $em->flush();
  }

  /**
   * Edits an existing AdviesRapport entity.
   *
   * @Route("/{shortname}/{id}/update", name="adviesrapport_update")
   * @Method("PUT")
   * @Template("CiviCoopVragenboomBundle:AdviesRapport:show.html.twig")
   */
  public function updateAction(Request $request, $shortname, $id) {
    $em = $this->getDoctrine()->getManager();
    $factory = $this->get('civicoop.vragenboom.rapportfactory');
    
    $entity = $em->getRepository($factory->getEntityFromShortname($shortname))->findOneById($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find AdviesRapport entity.');
    }

    $editForm = $this->createForm($factory->getNewForm($factory->getEntity($entity)), $entity);
    $editForm->bind($request);

    if ($editForm->isValid()) {
      if ($factory->getEntity($entity) == 'CiviCoopVragenboomBundle:EindRapport') {
        $status = $request->get('status');
        foreach($status as $rid => $s ) {
          foreach($entity->getRegels() as $regel) {
            if ($regel->getId() == $rid) {
              $regel->setStatus($s);
              $em->persist($regel);
              break;
            }
          }
        }
      }
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('adviesrapport_show', array('id' => $id, 'shortname' => $factory->getShortName($entity))));
    }

    return array(
      'entity' => $entity,
      'regel_form' => $regel_form->createView(),
    );
  }
  
  /**
   * Close an AdviesRapport entity.
   *
   * @Route("/{shortname}/{id}/close", name="adviesrapport_close")
   * @Method("GET")
   * @Template("CiviCoopVragenboomBundle:AdviesRapport:close.html.twig")
   */
  public function closeAction(Request $request, $shortname, $id) {
    $em = $this->getDoctrine()->getManager();
    $factory = $this->get('civicoop.vragenboom.rapportfactory');
    
    $entity = $em->getRepository($factory->getEntityFromShortname($shortname))->findOneById($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find AdviesRapport entity.');
    }
    
    $entityType = $factory->getEntity($entity);
    $rapport = $factory->getRapportGenerator($entityType)->createReport($entity);
    $this->get('civicoop.dgw.mutatieproces.civicase')->closeActivity($entity->getActivityId(), $rapport);
    $entity->setClosed(true);
    
    $em->persist($entity);
    $em->flush();

    return $this->redirect($this->generateUrl('adviesrapport'));
  }

}
