<?php

namespace CiviCoop\VragenboomBundle\Controller;

use CiviCoop\VragenboomBundle\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller {

  protected function getRuimte($ruimte) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('CiviCoopVragenboomBundle:Ruimte')->findOneBySlug($ruimte);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Ruimte entity.');
    }

    return $entity;
  }

  protected function getObject($object) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('CiviCoopVragenboomBundle:Object')->findOneBySlug($object);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Object entity.');
    }

    return $entity;
  }

  protected function getType() {
    $defaulttype = 'mutatieproces';

    $em = $this->getDoctrine()->getManager();
    $entity = $em->getRepository('CiviCoopVragenboomBundle:Type')->findOneBySlug($defaulttype);

    if (!$entity) {
      $entity = new Type();
      $entity->setName('mutatieproces');
      $em->persist($entity);
      $em->flush();
    }

    return $entity;
  }

}
