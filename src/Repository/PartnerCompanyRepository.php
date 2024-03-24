<?php

namespace App\Repository;

use App\Entity\PartnerCompany;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PartnerCompany>
 *
 * @method PartnerCompany|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartnerCompany|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartnerCompany[]    findAll()
 * @method PartnerCompany[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartnerCompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartnerCompany::class);
    }

    //    /**
    //     * @return PartnerCompany[] Returns an array of PartnerCompany objects
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

    //    public function findOneBySomeField($value): ?PartnerCompany
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
