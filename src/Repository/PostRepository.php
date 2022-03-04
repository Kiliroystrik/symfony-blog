<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */

    public function findPostsByCategory(Category $category)
    {
        //RETOURNE L'EQUIVALENT D'UN $category->getPosts() 
        //À NOTER LE 'MEMBER OF' QUI PERMET DE VERIFIER TOUTES LES CATÉGORIES (RELATION MANY TO MANY)
        $qb = $this->createQueryBuilder("p")
            ->where(':category MEMBER OF p.categories')
            ->setParameter('category', $category);

        return $qb->getQuery()->getResult();
    }



    /* VERSION INNER JOIN */
    public function search($val)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.user', 'u', 'WITH', 'u.id = p.user')
            ->andWhere('u.firstname LIKE  :val')
            ->orWhere('p.title LIKE  :val')
            ->orWhere('p.content LIKE  :val')
            ->setParameter('val', "%" . $val . "%")
            ->getQuery()
            ->getResult();
    }

    /* VERSION JOIN EQUIVALENTE */
    public function search2($val)
    {
        return $this->createQueryBuilder('p')
            ->join('p.user', 'u')
            ->addSelect('u')
            ->where('u.id = p.user')
            ->andWhere('u.firstname LIKE  :val')
            ->orWhere('p.title LIKE  :val')
            ->orWhere('p.content LIKE  :val')
            ->setParameter('val', "%" . $val . "%")
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    public function findByDates($from, $to)
    {
        $qb = $this->createQueryBuilder("p");
        $qb
            ->andWhere('p.publishedDate BETWEEN :from AND :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to);
        $posts = $qb->getQuery()->getResult();
        return $posts;
    }
}
