<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use App\Service\Entity;
use App\Service\Validator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture
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
            'AB20' => [
                'name' => 'Mabiala',
                'surname' => 'Jean',
            ],
            'AI452' => [
                'name' => 'KITOKO - NGOMA',
                'surname' => 'Hess',
            ],
            'ABY56' => [
                'name' => 'DELACROIX',
                'surname' => 'Jean Christophe',
            ],
            'AB59' => [
                'name' => 'DUPONT',
                'surname' => 'Xavier',
            ],
        ];

        foreach ($data as $matricule => $value) {
            $teacher = new Teacher();
            $teacher->setMatricule($matricule);
            $teacher->setSurname($value['surname']);
            $teacher->setName($value['name']);

            if ($this->validator->entity($teacher)) {
                $manager->persist($teacher);
            }
        }

        $manager->flush();
    }
}
