<?php

namespace App\Repository;

use App\Entity\Projects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projects::class);
    }

    // /**
    //  * @return Projet[] Returns an array of Projet objects
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
    public function myGetProjet($page)
    {
        return $this->createQueryBuilder('b')
        ->setFirstResult(($page-1)*6)
        ->setMaxResults(6)
        ->orderBy('b.date','ASC')
        ->getQuery()
        ->getResult()
        ;
    }
    public function myProjetSearch($search)
    {
        return $this->createQueryBuilder('b')
        // ->setFirstResult(($page-1)*6)
        ->where('b.titre LIKE :search')
        ->setParameter('search', '%'.$search.'%')
        ->setMaxResults(6)
        ->orderBy('b.date','ASC')
        ->getQuery()
        ->getResult()
        ;
    }
    public function myGetProjetByType($type,$page)
    {
        $query =  $this->createQueryBuilder('b')
        ->where('b.categorie = :type')
        ->setParameter('type', $type)
        ->setFirstResult(($page-1)*6)
        ->setMaxResults(6)
        ->orderBy('b.date','ASC')
      
        ->getQuery()
        ->getResult()
        ;
        return $query;
    }

    public function myCount()
    {
        return $this->createQueryBuilder('b')
            ->select('count(b)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
    public function myCountByTri($tri)
    {
        return $this->createQueryBuilder('b')
            ->select('count(b)')
            ->where("b.categorie like :type")
            ->setParameter("type" , $tri)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
    public function findOneByNext($date)
    {
        return $this->createQueryBuilder('b')
            ->select('b.id')
            ->addSelect('b.title')
            ->where("b.date > :date")
            ->setParameter("date" , $date)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findOneByPrevious($date)
    {
        return $this->createQueryBuilder('b')
            ->select('b.id')
            ->addSelect('b.title')
            ->where("b.date < :date")
            ->setParameter("date" , $date)
            ->setMaxResults(1)
            ->orderBy('b.date','DESC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Projet
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
