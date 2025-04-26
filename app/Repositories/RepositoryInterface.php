<?php

namespace App\Repositories;

interface RepositoryInterface
{

    public function getAll(): array;

    public function getById($id): mixed;
}
