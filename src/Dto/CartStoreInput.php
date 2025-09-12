<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class CartStoreInput implements \Serializable
{
    #[Groups(['cart:write', 'cart:read'])]
    public ?string $type = null;

    /**
     * @var CartStoreInputContent[]
     */
    #[Groups(['cart:write', 'cart:read'])]
    public array $content = [];

    public function serialize(): ?string
    {
        return json_encode($this) ?: null;
    }

    public function unserialize(string $data)
    {
        $json = json_decode($data, true);

        $this->type = $json['type'] ?? null;
        $this->content = [];
        for ($i = 0; $i < count($json['content']); ++$i) {
            $cartItem = new CartStoreInputContent();
            $cartItem->productId = $json['content'][0]['productId'] ?? null;
            $cartItem->quantity = $json['content'][0]['quantity'] ?? null;
            $this->content[] = $cartItem;
        }
    }

    public function __serialize(): array
    {
        return [
            'type' => $this->type,
            'content' => $this->content,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->unserialize(serialize($data));
    }
}
