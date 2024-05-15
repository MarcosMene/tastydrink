<?php

namespace App\Repository;

use App\Entity\ColorProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ColorProduct>
 *
 * @method ColorProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ColorProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ColorProduct[]    findAll()
 * @method ColorProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColorProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ColorProduct::class);
    }

//    /**
//     * @return ColorProduct[] Returns an array of ColorProduct objects
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

//    public function findOneBySomeField($value): ?ColorProduct
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
