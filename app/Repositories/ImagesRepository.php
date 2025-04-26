<?php

namespace App\Repositories;

use App\Models\Images;
use Illuminate\Support\Facades\DB;

class ImagesRepository implements ImagesRepositoryInterface
{
    /**
     * Get the list of images associated with a given product
     *
     * @param integer $productId
     * @return array
     */
    static function getImagesByProductId(int $productId): array
    {
        $result = [];

        $images = DB::table('images')
        ->join('product_images', function ($join) use ($productId) {
            $join->on('images.id', '=', 'product_images.image')
                 ->where('product_images.product', '=', $productId);
        })->get();

        $result = $images->toArray();

        return $result;
    }

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
        return Images::all()->toArray();
    }

    public function getById($id): ?Images
    {
        $imagesTable = DB::table('images');
        $images = $imagesTable->where('id', $id)->get();
        if(count($images)) {
            return $images->first();
        }

        return null;
    }
}
