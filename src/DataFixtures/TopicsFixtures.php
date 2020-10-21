<?php

namespace App\DataFixtures;

use App\Entity\Topics;
use App\Service\Entity;
use App\Service\Validator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TopicsFixtures extends Fixture
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
            'Mathématiques',
            'Français',
            'Histoire',
            'Géographie',
            'Philosophie',
            'Sciences Physiques',
            'Anglais',
        ];

        foreach ($data as $value) {
            $period = new Topics();
            $period->setname($value);

            if ($this->validator->entity($period)) {
                $manager->persist($period);
            }
        }

        $manager->flush();
    }
}
