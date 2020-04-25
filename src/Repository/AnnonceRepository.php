<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllAnnonceByOrga($orga)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.organisateur = :val')
            ->setParameter('val', $orga)
            ->orderBy('a.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAnnonceByIdAndOrga($id, $orga)
    {
        return $this->createQueryBuilder('a')
        ->andWhere('a.id = :id')
        ->andWhere('a.organisateur = :organisateur')
        ->setParameters(['id' => $id, 'organisateur' => $orga])
        ->orderBy('a.id', 'ASC')
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }

    public function findOneBySlugAndOrga($slug, $orga)
    {
        return $this->createQueryBuilder('a')
        ->andWhere('a.slug = :slug')
        ->andWhere('a.organisateur = :organisateur')
        ->setParameters(['slug' => $slug, 'organisateur' => $orga])
        ->orderBy('a.id', 'ASC')
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }

    public function findPaginatedAnnonces($from){
        // Create our query
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.date_begin', 'DESC')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $pages = $this->paginate($query, $from);
        return $pages;

    }

    private function paginate($dql, $page = 1, $limit = 6)
    {
        $paginator = new Paginator($dql);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }
}
