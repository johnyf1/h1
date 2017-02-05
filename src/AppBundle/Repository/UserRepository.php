<?php

namespace AppBundle\Repository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOneById($id,$customer){

        $queryBuilder = $this->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->andWhere('u.customer = :customer')
            ->setParameter('customer', $customer)
            ->setMaxResults(1);
        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

}
