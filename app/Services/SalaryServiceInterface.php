<?php

namespace App\Services;

interface SalaryServiceInterface
{
    public function setTime($time);

    public function getTime();

    public function setName($name);

    public function getName();

    public function getTimeOptions();

    public function getUserOptions();

    public function getAll();

    public function getMonth();

    public function getYear();
}
