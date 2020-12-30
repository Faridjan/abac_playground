<?php


namespace App;


class User
{

    public string $name;
    public int $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }
}