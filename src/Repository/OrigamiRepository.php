<?php

namespace App\Repository;

use App\Entity\Origami;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Origami>
 *
 * @method Origami|null find($id, $lockMode = null, $lockVersion = null)
 * @method Origami|null findOneBy(array $criteria, array $orderBy = null)
 * @method Origami[]    findAll()
 * @method Origami[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrigamiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Origami::class);
    }

    public function searchByQuery(string $query)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.name LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Origami[] Returns an array of Origami objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Origami
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
