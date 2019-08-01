<?php

namespace App\Repository;

use App\Entity\SmallEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmallEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmallEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmallEvent[]    findAll()
 * @method SmallEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmallEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SmallEvent::class);
    }

    // /**
    //  * @return SmallEvent[] Returns an array of SmallEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SmallEvent
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
