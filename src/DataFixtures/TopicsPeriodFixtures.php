<?php

namespace App\DataFixtures;

use App\Entity\Period;
use App\Entity\Topics;
use App\Entity\TopicsPeriod;
use App\Service\Entity;
use App\Service\Validator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TopicsPeriodFixtures extends Fixture
{
    private $entity;
    private $validator;

    public function __construct(Validator $validator, Entity $entity)
    {
        $this->entity = $entity;
        $this->validator = $validator;
    }

    public function load(ObjectManager $manager)
    {
        $data = [
            'mathematiques' => ['lundi'],
            'francais' => ['Mardi'],
            'histoire' => ['Mercredi'],
            'geographie' => ['jeudi'],
            'philosophie' => ['Vendredi'],
            'sciences-physiques' => ['Samedi'],
            'anglais' => ['Dimanche'],
        ];

        foreach ($data as $topic => $periods) {
            $topics_period = new TopicsPeriod();

            $topics = $manager->getRepository(Topics::class)->findOneBySlug($topic);

            foreach ($periods as $value) {
                $period = $manager->getRepository(Period::class)->findOneBySlug($value);

                if ($period) {
                    $topics_period->setPeriod($period);
                }

                if ($topics) {
                    $topics_period->setTopics($topics);
                }

                $topics_period_exist = $manager->getRepository(TopicsPeriod::class)->getBySlug($topic, $value);

                if (!$topics_period_exist && $this->validator->entity($topics_period)) {
                    $manager->persist($topics_period);
                }
            }
        }

        $manager->flush();
    }
}
