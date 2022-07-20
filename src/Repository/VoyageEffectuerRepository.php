<?php

namespace App\Repository;

use App\Entity\VoyageEffectuer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VoyageEffectuer>
 *
 * @method VoyageEffectuer|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoyageEffectuer|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoyageEffectuer[]    findAll()
 * @method VoyageEffectuer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageEffectuerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VoyageEffectuer::class);
    }

    public function add(VoyageEffectuer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VoyageEffectuer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VoyageEffectuer[] Returns an array of VoyageEffectuer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VoyageEffectuer
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
