<?php

namespace App\DataFixtures;

use App\Entity\Student;
use App\Service\Entity;
use App\Service\Validator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
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
            [
                'name' => 'LAWSON',
                'surname' => 'Earvin',
                'matricule' => 'ENT85Z',
            ],
            [
                'name' => 'KITOKO - NGOMA',
                'surname' => 'Emmanuelle',
                'matricule' => 'EXCT98',
            ],
            [
                'name' => 'LOUTEZAMO',
                'surname' => 'Pénéloppe',
                'matricule' => 'RTUI32',
            ],
            [
                'name' => 'MAVOUNGOU',
                'surname' => 'Halachi',
                'matricule' => 'ADT89',
            ],
        ];

        foreach ($data as $value) {
            $student = new Student();
            $student->setSurname($value['surname']);
            $student->setName($value['name']);
            $student->setMatricule($value['matricule']);

            if ($this->validator->entity($student)) {
                $manager->persist($student);
            }
        }

        $manager->flush();
    }
}
