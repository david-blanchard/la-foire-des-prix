<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductOneTest extends TestCase
{

    /**
     * Test if a product with ID 1 exists
     *
     * @return void
     */
    public function test_productOneExists()
    {
        $row = DB::table('products')->select('id')->get()->first();

        $this->assertEquals($row->id, 1);
    }

    /**
     * Test if product one name is Veste en jean
     *
     * @return void
     */
    public function test_productOneIsVesteEnJean()
    {
        $row = DB::table('products')->select('name')->get()->first();

        $this->assertStringContainsString('Veste en jean', $row->name);
    }

    /**
     * Test if product one name contains robe
     *
     * @return void
     */
    public function test_productOneIsNotRobe()
    {
        $row = DB::table('products')->select('name')->get()->first();

        $this->assertStringNotContainsString('Robe', $row->name);
    }

    /**
     * Test if Veste en jean is 37.99 euros
     *
     * @return void
     */
    public function test_productOnePriceIs_38_euros()
    {
        $row = DB::table('products')->select('price')->get()->first();

        $this->assertEquals($row->price, 37.99);
    }
}
