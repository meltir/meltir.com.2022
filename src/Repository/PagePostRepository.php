<?php

namespace App\Repository;

use App\Entity\PagePost;
use Gedmo\Sortable\Entity\Repository\SortableRepository;

/**
 * @extends SortableRepository<PagePost>
 *
 * @method PagePost|null find($id, $lockMode = null, $lockVersion = null)
 * @method PagePost|null findOneBy(array $criteria, array $orderBy = null)
 * @method PagePost[]    findAll()
 * @method PagePost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PagePostRepository extends SortableRepository
{
    public function add(PagePost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PagePost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return PagePost[]
     */
    public function findForThisPage(string $page): array
    {
        return $this->getBySortableGroupsQueryBuilder(['page' => $page])
            ->andWhere('n.active = true')
            ->andWhere('n.parent_post is null')
            ->addOrderBy('n.id')
            ->getQuery()
            ->getResult();
    }
}
