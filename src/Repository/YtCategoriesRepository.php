<?php

namespace App\Repository;

use App\Entity\YtCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<YtCategories>
 *
 * @method YtCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method YtCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method YtCategories[]    findAll()
 * @method YtCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YtCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YtCategories::class);
    }

    public function add(YtCategories $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(YtCategories $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return YtCategories[]
     */
    public function getActiveCategories(): array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.active = true')
            ->orderBy('n.cat_order')
            ->getQuery()
            ->getResult();
    }
}
