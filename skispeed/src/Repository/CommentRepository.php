<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

/*
     public function findOneBy(string $figure)
    {
        $query = $this->createQueryBuilder('c')
        ->where('c.figure = :figure')
        ->setParameter('figure', $figure)
        ->orderBy('c.createdAt', 'DESC')
        ->getQuery()
        ->getResult();
    }
*/
   /* public function displayFigures(figure $figure, $page, $maxPerpage)
    {
        $query = $this->createQueryBuilder('c')
        ->where('c.figure = :figure')
        ->orderBy('c.createdAt', 'DESC')
        ->getQuery();

        $paginator = $this->paginate($query, $page, $maxPerPage);

        return new paginator;
    }
*/
   /* public function paginate($query, $page = 1, $maxPerPage = 8)
    {
        $paginator = new Paginator($query);

        $paginator->getQuery($query)
            ->setFirstResult($maxPerPage * ($page - 1))
            ->setMaxresults($maxPerPage);

        return $paginator;
    }
}*/
    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ; */
    }
   

