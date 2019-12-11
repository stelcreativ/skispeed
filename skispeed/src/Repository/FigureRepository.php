<?php

namespace App\Repository;

use App\Entity\Figure;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Figure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Figure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Figure[]    findAll()
 * @method Figure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FigureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Figure::class);
    }

    /**
    * @return figure[]
    */
    public function findOneBySlug(string $slug)
    {
        return $this->createQueryBuilder('figure')
            ->select('figure.slug')
            ->where('slug IS NOT NULL') 
            ->setParameter('slug', $slug)
            ->orderBy('figure.id', 'DESC')
            ->getQuery()
            ->getResult();

    
    }
 
    /**
     * @param integer $page
     */

    public function getFiguresList($page)
    {
        $query = $this->createQueryBuilder('figure')
        ->orderBy('figure.createdAt', 'DESC')
        ->setFirstResult(($page-1) * 6)
        ->setMaxResults(6)
        ->getQuery();

        return new Paginator($query, true);
    }

    public function countFigures()
    {
       $count = $this->createQueryBuilder('figure')
       ->select("COUNT(DISTINCT figure.id)")
       ->getQuery()
       ->getSingleScalarResult();

       return $count;
    }

    public function findAllVisible()
    {
        return $this->findVisibleQuery()
        ->where('figure.id = true')
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return Figure[] Returns an array of Figure objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Figure
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
