<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|Article find($id, $lockMode = null, $lockVersion = null)
 * @method null|Article findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findAllPublishedOrderedByNewest()
    {
        $this->createQueryBuilder('a')
            ->addCriteria(CommentRepository::createNonDeletedCriteria())
        ;

        return $this->addIsPublishedQueryBuilder()
            ->leftJoin('a.tags', 't')
            ->addSelect('t')
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function store(Article $article): void
    {
        $this->_em->persist($article);
        $this->_em->flush();
    }

    public function remove($article): void
    {
        $this->_em->remove($article);
        $this->_em->flush();
    }

    private function getOrCreateQueryBuilder(?QueryBuilder $qb = null): QueryBuilder
    {
        return $qb ?: $this->createQueryBuilder('a');
    }

    private function addIsPublishedQueryBuilder(?QueryBuilder $qb = null): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder($qb)
            ->andWhere('a.publishedAt IS NOT NULL')
        ;
    }
}
