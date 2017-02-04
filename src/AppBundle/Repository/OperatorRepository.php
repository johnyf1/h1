<?php

namespace AppBundle\Repository;

/**
 * OperatorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OperatorRepository extends \Doctrine\ORM\EntityRepository
{
    public function findActiveOperatorByPhoneNumber($number){

        $queryBuilder = $this->createQueryBuilder('o')
            ->where('o.enabled = :enabled')
            ->setParameter('enabled', true)
            ->andWhere('o.phoneNumber = :phoneNumber')
            ->setParameter('phoneNumber', $number)
            ->setMaxResults(1);
        return $queryBuilder->getQuery()->getOneOrNullResult();
    }    
}
