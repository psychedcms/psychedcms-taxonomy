<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PsychedCms\Taxonomy\Entity\Taxonomy;

/**
 * @extends ServiceEntityRepository<Taxonomy>
 */
class TaxonomyRepository extends ServiceEntityRepository implements TaxonomyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Taxonomy::class);
    }

    public function findByType(string $type): iterable
    {
        return $this->createQueryBuilder('t')
            ->where('t.type = :type')
            ->setParameter('type', $type)
            ->orderBy('t.sortOrder', 'ASC')
            ->addOrderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findRootsByType(string $type): iterable
    {
        return $this->createQueryBuilder('t')
            ->where('t.type = :type')
            ->andWhere('t.parent IS NULL')
            ->setParameter('type', $type)
            ->orderBy('t.sortOrder', 'ASC')
            ->addOrderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByTypeAndSlug(string $type, string $slug): ?Taxonomy
    {
        return $this->createQueryBuilder('t')
            ->where('t.type = :type')
            ->andWhere('t.slug = :slug')
            ->setParameter('type', $type)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByTypeAndSlugs(string $type, array $slugs): iterable
    {
        return $this->createQueryBuilder('t')
            ->where('t.type = :type')
            ->andWhere('t.slug IN (:slugs)')
            ->setParameter('type', $type)
            ->setParameter('slugs', $slugs)
            ->orderBy('t.sortOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function save(Taxonomy $taxonomy): void
    {
        $this->getEntityManager()->persist($taxonomy);
        $this->getEntityManager()->flush();
    }

    public function delete(Taxonomy $taxonomy): void
    {
        $this->getEntityManager()->remove($taxonomy);
        $this->getEntityManager()->flush();
    }
}
