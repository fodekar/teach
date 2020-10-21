<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    private $em;
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->em = $entityManager;
        $this->validator = $validator;
    }

    public function entity($data)
    {
        $errors = count($this->validator->validate($data));

        return ($errors < 1) ? true : false;
    }

    protected function getRepository($name)
    {
        return $this->em->getRepository($name);
    }
}
