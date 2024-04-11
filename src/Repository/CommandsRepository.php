<?php

namespace App\Repository;

use App\Entity\Commands;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commands>
 *
 * @method Commands|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commands|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commands[]    findAll()
 * @method Commands[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commands::class);
    }

//    /**
//     * @return Commands[] Returns an array of Commands objects
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

//    public function findOneBySomeField($value): ?Commands
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
