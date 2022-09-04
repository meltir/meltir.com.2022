<?php

namespace App\Repository;

use App\Entity\YtCategories;
use App\Entity\YtChannels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<YtChannels>
 *
 * @method YtChannels|null find($id, $lockMode = null, $lockVersion = null)
 * @method YtChannels|null findOneBy(array $criteria, array $orderBy = null)
 * @method YtChannels[]    findAll()
 * @method YtChannels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YtChannelsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YtChannels::class);
    }

    public function add(YtChannels $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(YtChannels $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return YtChannels[] Returns an array of YtChannels objects
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

//    public function findOneBySomeField($value): ?YtChannels
//    {
//        return $this->createQueryBuilder('y')
//            ->andWhere('y.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function isChannelActive(YtChannels $channel): bool
    {
        if ($channel->getCategory()->getActive()) {
            return true;
        }

        return false;
    }

    /**
     * @return YtChannels[]
     */
    public function getChannelPage(int $page = 1, int $per_page = 10, ?YtCategories $category): array
    {
        $query = $this->createQueryBuilder('n')
            ->addOrderBy('n.category')
            ->join('n.category', 'c')
            ->andWhere('c.active = true')
            ->setMaxResults($per_page)
            ->setFirstResult(1);
        if ($page > 1) {
            $query->setFirstResult(($page - 1) * $per_page + 1);
        }
        if ($category) {
            $query->andWhere('n.category = :cat')
                ->setParameter('cat', $category);
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countPages(int $per_page, ?YtCategories $category): int
    {
        $query = $this->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->join('n.category', 'c')
            ->andWhere('c.active = true');
        if ($category) {
            $query->andWhere('n.category = :cat')
                ->setParameter('cat', $category);
        }
        $full_count = $query
            ->getQuery()
            ->getSingleScalarResult();

        return floor($full_count / $per_page);
    }

    /**
     * @return YtChannels[]
     */
    public function findActiveChannels(int $startRow = 0, int $per_page = 0): array
    {
        $query = $this->createQueryBuilder('n')
            ->join('n.category', 'c')
            ->andWhere('c.active = true');
        if (0 != $startRow && 0 != $per_page) {
            $query->setFirstResult($startRow);
            $query->setMaxResults($per_page);
        }

        return $query
            ->getQuery()
            ->getResult();
    }
}
