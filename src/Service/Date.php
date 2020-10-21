<?php

namespace App\Service;

class Date
{
    public function format($date)
    {
        return $date->format('Y-m-d');
    }

    public function getTime($format = 'H:i')
    {
        return (new \DateTime('now'))->format($format);
    }

    public function getDateTime()
    {
        return new \DateTime();
    }

    public function curentDateTime($format = 'Y-m-d H:i:s')
    {
        return (new \DateTime('now'))->format($format);
    }
}
