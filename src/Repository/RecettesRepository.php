<?php

namespace App\Repository;

use App\Entity\Recettes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recettes>
 *
 * @method Recettes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recettes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recettes[]    findAll()
 * @method Recettes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecettesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recettes::class);
    }

    public function save(Recettes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Recettes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Recettes[] Returns an array of Recettes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Recettes
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findByUser($userId)
{
    return $this->createQueryBuilder('m')
        ->andWhere('m.genres LIKE :user_id')
        ->setParameter('user_id', "%$userId%")
        ->getQuery()
        ->getResult();
}
public function findRecetteById($value): ?Recettes
{
    return $this->createQueryBuilder('u')
        ->andWhere('u.id = :val')
        ->setParameter('val', $value)
        ->getQuery()
        ->getOneOrNullResult()
    ;
}
public function findByAllergie($value): array
{
    $entityManager = $this->getEntityManager();

    $query = $entityManager->createQuery(
        'SELECT r
FROM App\Entity\Recettes r
WHERE r.ingredientsAll NOT LIKE :ingredientsAll
ORDER BY r.ingredientsAll ASC'
    )->setParameter('ingredientsAll', '%'.$value .'%');

    // returns an array of Product objects
    return $query->getResult();
}

public function findByUserAndAllergie($ingredient, $user): array
{
    $entityManager = $this->getEntityManager();

    $query = $entityManager->createQuery(
        'SELECT r
FROM App\Entity\Recettes r
WHERE r.user = :user AND r.ingredientsAll NOT LIKE :ingredientsAll 
ORDER BY r.ingredientsAll ASC'
    )->setParameter('ingredientsAll', '%' . $ingredient . '%')
        ->setParameter('user', $user);

    // returns an array of Product objects
    return $query->getResult();
}
}

