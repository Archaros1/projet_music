<?php

namespace App\Repository;

use App\Entity\GroupeType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GroupeType|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeType|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeType[]    findAll()
 * @method GroupeType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeType::class);
    }

    // /**
    //  * @return GroupeType[] Returns an array of GroupeType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupeType
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
