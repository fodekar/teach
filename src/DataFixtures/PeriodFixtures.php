<?php

namespace App\DataFixtures;

use App\Entity\Period;
use App\Service\Entity;
use App\Service\Validator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PeriodFixtures extends Fixture
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
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi',
            'Samedi',
            'Dimanche',
        ];

        foreach ($data as $value) {
            $period = new Period();
            $period->setLabel($value);

            if ($this->validator->entity($period)) {
                $manager->persist($period);
            }
        }

        $manager->flush();
    }
}
