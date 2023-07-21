<?php

namespace App\Repository;

use App\Entity\RecetteIngredients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecetteIngredients>
 *
 * @method RecetteIngredients|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecetteIngredients|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecetteIngredients[]    findAll()
 * @method RecetteIngredients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteIngredientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecetteIngredients::class);
    }

    public function save(RecetteIngredients $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RecetteIngredients $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RecetteIngredients[] Returns an array of RecetteIngredients objects
//     */
   public function findByRecette($recetteId): array
   {
       return $this->createQueryBuilder('r')
           ->andWhere('r.recetteId = :val')
           ->setParameter('val', $recetteId)
           ->orderBy('r.id', 'ASC')
       //    ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?RecetteIngredients
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
