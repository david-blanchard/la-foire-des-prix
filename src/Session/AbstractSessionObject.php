<?php

namespace App\Session;

use App\Utils\ObjectUtilsTrait;

abstract class AbstractSessionObject implements SessionObjectInterface
{
    use ObjectUtilsTrait;

    private $list = [];

    abstract public function prepareViewFields(): array;

    abstract static public function type(): string;

    abstract public function prepare(?array $data = null): void;

    public function items(): array
    {
        return $this->list;
    }

    public function add(array $item): void
    {
        $key = key($item);
        $value = $item[$key];

        $oldValue = isset($this->list[$key]) ? $this->list[$key] : null;

        if ($oldValue !== null && is_numeric($oldValue) && is_numeric($value)) {
            $value = $oldValue + $value;
        }

        $this->list[$key] = $value;
    }

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
     * Convert a session object to its session form
     *
     * @return array session data
     */
    public function makeSessionObject(): array
    {
        return [
            "type" => $this->type(),
            "content" => $this->items(),
        ];
    }

    /**
     * Used to make a default object
     *
     * @return array
     */
    abstract public function makeEmptySessionObject(): array;
}
