<?php

namespace App\Repository;

use App\Entity\ReviewClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReviewClient>
 *
 * @method ReviewClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReviewClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReviewClient[]    findAll()
 * @method ReviewClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReviewClient::class);
    }
}
