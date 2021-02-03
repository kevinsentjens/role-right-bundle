<?php

namespace App\Repository;

use App\Entity\KSRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KSRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method KSRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method KSRole[]    findAll()
 * @method KSRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KSRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KSRole::class);
    }

    // /**
    //  * @return KSRole[] Returns an array of KSRole objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KSRole
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
