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
}
