<?php

namespace App\Session;

use App\Services\CartService;
use Illuminate\Contracts\Foundation\Application;

class SessionObjectFactory implements SessionObjectFactoryInterface
{
    public function __construct(
        private Application $app
    ) {
    }

    public function create(array $data) : ?SessionObjectInterface
    {

        $result = null;

        if(!isset($data["type"])) {
            return $result;
        }

        if( $data["type"] === CartService::type()) {
            $result = $this->app->make(CartService::class);
        }

        return $result;

    }

}
