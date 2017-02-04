<?php

namespace AppBundle\Repository;

/**
 * PhoneNumberRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PhoneNumberRepository extends \Doctrine\ORM\EntityRepository
{
    public function isPhoneNumberPublic($number){

        $queryBuilder = $this->createQueryBuilder('n')
            ->where('n.isPublic = :isPublic')
            ->setParameter('isPublic', 0)
            ->andWhere('n.phoneNumber = :phoneNumber')
            ->setParameter('phoneNumber', $number)
            ->setMaxResults(1);
        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
    
    
}
