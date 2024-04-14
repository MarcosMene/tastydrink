<?php

namespace App\Repository;

use App\Entity\Departament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departament>
 *
 * @method Departament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departament[]    findAll()
 * @method Departament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departament::class);
    }

//    /**
//     * @return Departament[] Returns an array of Departament objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Departament
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
