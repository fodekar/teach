<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function getByTopicsPeriod($topic, $period)
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->leftJoin('c.topicsPeriod', 'tp', 'WITH', 'tp.id = c.topicsPeriod')
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
