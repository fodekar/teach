<?php

namespace App\Service;

use Doctrine\DBAL\ConnectionException;
use Doctrine\ORM\EntityManagerInterface;

class Entity
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getEntityManager($container, $w = false)
    {
        $em = $container->get('doctrine.orm.entity_manager');

        if (!$em->isOpen()) {
            $em = $em->create(
                $em->getConnection(),
                $em->getConfiguration()
            );
        }

        if ($w) {
            return $em;
        }

        if (!$this->em) {
            $this->em = $em;
        }

        return $this->em;
    }

    public function flush($em, $iteration = false, $counter = 0, $limit = false)
    {
        if ($iteration) {
            if ($counter) {
                if (($counter % $limit) === 0) {
                    $this->commit($em, 2);
                }
            } else {
                $this->commit($em, 2);
            }
        } else {
            $this->commit($em);
        }
    }

    private function commit($em, $action = 1)
    {
        switch ($action) {
            case 1:
            default:
                $this->push($em, true);
                break;
            case 2:
                $this->push($em);
                break;
        }
    }

    public function start($em)
    {
        $em->getConnection()->beginTransaction();
    }

    public function push($em, $clear = false)
    {
        $em->flush();

        if ($this->isTransaction($em)) {
            $connection = $em->getConnection();

            try {
                $connection->commit();
            } catch (ConnectionException $e) {
                $this->rollback($em);
            }
        }

        if ($clear) {
            $em->clear();
        }
    }

    public function rollback($em)
    {
        $connection = $em->getConnection();

        if ($this->isTransaction($em)) {
            $connection->rollBack();
        }

        $em->clear();
    }

    public function isTransaction($em)
    {
        $connection = $em->getConnection();

        return ($connection->isTransactionActive() && $connection->getTransactionNestingLevel()) ? true : false;
    }
}
