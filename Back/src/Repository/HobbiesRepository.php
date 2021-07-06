<?php

namespace App\Repository;

use App\Entity\Hobbies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hobbies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hobbies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hobbies[]    findAll()
 * @method Hobbies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HobbiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hobbies::class);
    }

    public function findByMusique_moment()
    {
        return $this->createQueryBuilder('musique_moment')
            ->where('musique_moment.musique_moment = true')
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return Hobbies[] Returns an array of Hobbies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hobbies
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
