<?php

namespace App\Repository;

use App\Entity\YtChannels;
use App\Entity\YtVideos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<YtVideos>
 *
 * @method YtVideos|null find($id, $lockMode = null, $lockVersion = null)
 * @method YtVideos|null findOneBy(array $criteria, array $orderBy = null)
 * @method YtVideos[]    findAll()
 * @method YtVideos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YtVideosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YtVideos::class);
    }

    public function add(YtVideos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(YtVideos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return YtVideos[] Returns an array of YtVideos objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('y')
//            ->andWhere('y.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('y.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?YtVideos
//    {
//        return $this->createQueryBuilder('y')
//            ->andWhere('y.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function getLatestVideosQuery(YtChannels $channel, int $count = 10, int $page = 1): Query
    {
        $query = $this->createQueryBuilder('n')
            ->andWhere('n.channel = :chan')
            ->setParameter('chan', $channel)
            ->orderBy('n.date_published', 'DESC')
            ->setMaxResults($count);
        if ($page > 1) {
            $query->setFirstResult($page * $count);
        }

        return $query->getQuery();
    }
}
