<?php

namespace App\Session;

interface SessionObjectFactoryInterface
{
    public function create(array $data) : ?SessionObjectInterface;

}
