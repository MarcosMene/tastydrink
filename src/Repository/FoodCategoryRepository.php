<?php

namespace App\Repository;

use App\Entity\FoodCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FoodCategory>
 *
 * @method FoodCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FoodCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FoodCategory[]    findAll()
 * @method FoodCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodCategoryRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, FoodCategory::class);
  }

  //    /**
  //     * @return FoodCategory[] Returns an array of FoodCategory objects
  //     */
  //    public function findByExampleField($value): array
  //    {
  //        return $this->createQueryBuilder('f')
  //            ->andWhere('f.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->orderBy('f.id', 'ASC')
  //            ->setMaxResults(10)
  //            ->getQuery()
  //            ->getResult()
  //        ;
  //    }

  //    public function findOneBySomeField($value): ?FoodCategory
  //    {
  //        return $this->createQueryBuilder('f')
  //            ->andWhere('f.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->getQuery()
  //            ->getOneOrNullResult()
  //        ;
  //    }
}
