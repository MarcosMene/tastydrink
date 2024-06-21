<?php

namespace App\Repository;

use App\Entity\BarTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BarTime>
 *
 * @method BarTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method BarTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method BarTime[]    findAll()
 * @method BarTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BarTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BarTime::class);
    }
}
