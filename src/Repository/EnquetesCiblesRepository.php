<?php

namespace App\Repository;

use App\Entity\EnquetesCibles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EnquetesCibles>
 *
 * @method EnquetesCibles|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnquetesCibles|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnquetesCibles[]    findAll()
 * @method EnquetesCibles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnquetesCiblesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnquetesCibles::class);
    }

    public function add(EnquetesCibles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EnquetesCibles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EnquetesCibles[] Returns an array of EnquetesCibles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EnquetesCibles
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
