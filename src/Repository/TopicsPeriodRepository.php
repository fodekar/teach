<?php

namespace App\Repository;

use App\Entity\TopicsPeriod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TopicsPeriod|null find($id, $lockMode = null, $lockVersion = null)
 * @method TopicsPeriod|null findOneBy(array $criteria, array $orderBy = null)
 * @method TopicsPeriod[]    findAll()
 * @method TopicsPeriod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicsPeriodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TopicsPeriod::class);
    }

    public function getBySlug($topic, $period)
    {
        $qb = $this
            ->createQueryBuilder('tp')
            ->leftJoin('tp.topics', 't', 'WITH', 't.id = tp.topics')
            ->leftJoin('tp.period', 'p', 'WITH', 'p.id = tp.period');

        $qb
            ->where('t.slug = :topic')
            ->andWhere('p.slug = :period')
            ->setParameters([
                'topic' => $topic,
                'period' => $period,
            ]);

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }
}
