<?php

namespace Tests\Feature;

use App\Repositories\ImagesRepository;
use App\Models\ProductImages;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Test if registration is valid.
     *
     * @return void
     */
    public function test_productPantalonIsCreatedWithoutImage()
    {

        Products::create([
            "name" => "Pantalon été toile légère Blanc",
            "description" => "Pantalon été toile légère Blanc. Petites poches pratiques. Fermeture à boutons simili ivoire.",
            "more_infos" => "Lavage à 30°;100% coton",
            "price" => 29.9,
            "brand" => 3,
        ]);

        $products = DB::table("products")->where("name", "like", "Pantalon%")->get();
        $product = $products->first();

        $this->assertStringContainsString("toile", $product->name);

    }

    public function test_productPantalonWithoutImageIsDeleted()
    {
        $products = DB::table("products")->where("name", "like", "Pantalon%")->get();
        $product = $products->first();

        $id = $product->id;

        $products = DB::table('products')->delete($id);

        $products = DB::table("products")->where("name", "like", "Pantalon%")->get();
        $product = $products->first();

        $this->assertNull($product);

    }

    /**
     * Test if registration is invalid.
     *
     * @return void
     */
    public function test_productPantalonIsCreatedWithImages()
    {

        Products::create([
            "name" => "Pantalon été toile légère Blanc",
            "description" => "Pantalon été toile légère Blanc. Petites poches pratiques. Fermeture à boutons simili ivoire.",
            "more_infos" => "Lavage à 30°;100% coton",
            "price" => 29.9,
            "brand" => 3,
        ]);

        $products = DB::table("products")->where("name", "like", "Pantalon%")->get();
        $product = $products->first();

        $id = $product->id;

        ProductImages::create([
            'product' => $id,
            'image' => 10,
        ]);
        ProductImages::create([
            'product' => $id,
            'image' => 11,
        ]);
        ProductImages::create([
            'product' => $id,
            'image' => 12,
        ]);

        $imagesRepository = new ImagesRepository();

        $images = $imagesRepository->getImagesByProductId($id);

        $this->assertIsArray($images);
    }

    public function test_productPantalonWithImagesIsDeleted()
    {
        $products = DB::table("products")->where("name", "like", "Pantalon%")->get();
        $product = $products->first();

        $id = $product->id;

        $products = DB::table('products')->delete($id);

        $products = DB::table("products")->where("name", "like", "Pantalon%")->get();
        $product = $products->first();

        $this->assertNull($product);

    }

}
