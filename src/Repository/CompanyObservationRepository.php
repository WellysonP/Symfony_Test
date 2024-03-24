<?php

namespace App\Repository;

use App\Entity\CompanyObservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyObservation>
 *
 * @method CompanyObservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyObservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyObservation[]    findAll()
 * @method CompanyObservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyObservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyObservation::class);
    }

    //    /**
    //     * @return CompanyObservation[] Returns an array of CompanyObservation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CompanyObservation
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
