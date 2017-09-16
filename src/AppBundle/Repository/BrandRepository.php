<?php

namespace AppBundle\Repository;

/**
 * BrandRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BrandRepository extends \Doctrine\ORM\EntityRepository
{

    public function findToArray($id){
        $results = $this->createQueryBuilder('brand')
            ->where('brand.id = :id')
            ->setParameters([
                'id' => $id
            ])
            ->getQuery()
            ->getArrayResult()
        ;

        return $results;
    }

}
