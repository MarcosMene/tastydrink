<?php

namespace App\Repository;

use App\Entity\DrinkCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DrinkCategory>
 *
 * @method DrinkCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method DrinkCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method DrinkCategory[]    findAll()
 * @method DrinkCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrinkCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DrinkCategory::class);
    }

//    /**
//     * @return DrinkCategory[] Returns an array of DrinkCategory objects
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

//    public function findOneBySomeField($value): ?DrinkCategory
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
