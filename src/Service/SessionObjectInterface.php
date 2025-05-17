<?php

namespace App\Service;

interface SessionObjectInterface
{
    public static function type(): string;

    /**
     * @return array<string, mixed>
     */
    public function items(): array;

    /**
     * @param array<string, mixed> $item
     */
    public function add(array $item): void;

    public function remove(int|string $key): bool;

    /**
     * @param array<string, mixed> $item
     */
    public function update(array $item): void;

    public function clear(): void;

    /**
     * @return array<string, mixed>
     */
    public function retrieve(): array;

    /**
     * @param array<string, mixed>|null $data
     */
    public function prepare(?array $data = null): void;

    /**
     * @param array<mixed> $input
     *
     * @return void
     */
    public function store(array $input): void;
}
