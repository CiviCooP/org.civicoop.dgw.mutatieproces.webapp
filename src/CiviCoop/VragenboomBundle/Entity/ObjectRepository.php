<?php

namespace CiviCoop\VragenboomBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ObjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObjectRepository extends EntityRepository
{
	public function findAllByRuimteOrderByNaam(Ruimte $ruimte)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM CiviCoopVragenboomBundle:Object p WHERE p.ruimte = :ruimte ORDER BY p.naam ASC'
            )
			->setParameter(':ruimte', $ruimte)
            ->getResult();
    }
}
