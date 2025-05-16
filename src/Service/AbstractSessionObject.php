<?php

namespace App\Service;

use App\Service\Traits\ObjectUtils;

abstract class AbstractSessionObject implements SessionObjectInterface
{
    use ObjectUtils;

    /**
     * @var array<int|string, mixed>
     */
    private array $list = [];

    /**
     * @return array<string, mixed>
     */
    abstract public function prepareViewFields(): array;

    abstract public static function type(): string;

    /**
     * @param array<int|string, mixed>|null $data
     */
    abstract public function prepare(?array $data = null): void;

    /**
     * @return array<int|string, mixed>
     */
    public function items(): array
    {
        return $this->list;
    }

    /**
     * @param array<int|string, mixed> $item
     */
    public function add(array $item): void
    {
        $key = key($item);
        $value = $item[$key];

        $oldValue = $this->list[$key] ?? null;

        if (null !== $oldValue && is_numeric($oldValue) && is_numeric($value)) {
            $value = $oldValue + $value;
        }

        $this->list[$key] = $value;
    }

    /**
     * @param array<int|string, mixed> $item
     */
    public function update(array $item): void
    {
        [$key, $value] = $item;
        $this->list[$key] = $value;
    }

    public function remove(int|string $key): bool
    {
        $result = false;

        if (isset($this->list[$key])) {
            unset($this->list[$key]);
            $result = true;
        }

        return $result;
    }

    public function clear(): void
    {
        $this->list = [];
    }

    /**
     * Convert a session object to its session form.
     *
     * @return array<string, mixed> session data
     */
    public function makeSessionObject(): array
    {
        return [
            'type' => $this->type(),
            'content' => $this->items(),
        ];
    }

    /**
     * Used to make a default object.
     *
     * @return array<string, mixed> session data
     */
    abstract public function makeEmptySessionObject(): array;
}
