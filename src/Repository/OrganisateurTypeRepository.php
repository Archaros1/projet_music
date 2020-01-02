<?php

namespace App\Repository;

use App\Entity\OrganisateurType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OrganisateurType|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrganisateurType|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrganisateurType[]    findAll()
 * @method OrganisateurType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganisateurTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrganisateurType::class);
    }

    // /**
    //  * @return OrganisateurType[] Returns an array of OrganisateurType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrganisateurType
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
