<?php

namespace App\Repository;

use App\Entity\GoogleTokenStorage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GoogleTokenStorage>
 *
 * @method GoogleTokenStorage|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoogleTokenStorage|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoogleTokenStorage[]    findAll()
 * @method GoogleTokenStorage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoogleTokenStorageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GoogleTokenStorage::class);
    }

    public function add(GoogleTokenStorage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GoogleTokenStorage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GoogleTokenStorage[] Returns an array of GoogleTokenStorage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GoogleTokenStorage
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
