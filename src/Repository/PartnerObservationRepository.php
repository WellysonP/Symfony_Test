<?php

namespace App\Repository;

use App\Entity\PartnerObservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PartnerObservation>
 *
 * @method PartnerObservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartnerObservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartnerObservation[]    findAll()
 * @method PartnerObservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartnerObservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartnerObservation::class);
    }

    

    //    /**
    //     * @return PartnerObservation[] Returns an array of PartnerObservation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PartnerObservation
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
