<?php

namespace App\Session;

interface SessionObjectInterface
{
    public static function type(): string;
    public function items() : array;
    public function add(array $item);
    public function remove(int|string $key): bool;
    public function update(array $item): void;
    public function clear(): void;
    public function prepareViewFields(): array;
    public function retrieve(): array;
    public function prepare(?array $data = null): void;
    public function store(array $input): array;
}
