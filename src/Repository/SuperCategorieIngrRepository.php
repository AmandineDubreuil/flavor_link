<?php

namespace App\Repository;

use App\Entity\SuperCategorieIngr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuperCategorieIngr>
 *
 * @method SuperCategorieIngr|null find($id, $lockMode = null, $lockVersion = null)
 * @method SuperCategorieIngr|null findOneBy(array $criteria, array $orderBy = null)
 * @method SuperCategorieIngr[]    findAll()
 * @method SuperCategorieIngr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuperCategorieIngrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuperCategorieIngr::class);
    }

    public function save(SuperCategorieIngr $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SuperCategorieIngr $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SuperCategorieIngr[] Returns an array of SuperCategorieIngr objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SuperCategorieIngr
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
