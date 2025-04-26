<?php

namespace App\Observers;

use App\Models\Products;
use Illuminate\Support\Str;

class ProductsObserver
{
    /**
     * Handle the Products "created" event.
     *
     * @param  \App\Models\Products  $product
     * @return void
     */
    public function created(Products $product)
    {
        $product->slug = Str::slug($product->name, '-');
        $product->save();
    }

    /**
     * Handle the Products "updated" event.
     *
     * @param  \App\Models\Products  $product
     * @return void
     */
    public function updated(Products $product)
    {
        //
    }

    /**
     * Handle the Products "deleted" event.
     *
     * @param  \App\Models\Products  $product
     * @return void
     */
    public function deleted(Products $product)
    {
        //
    }

    /**
     * Handle the Products "restored" event.
     *
     * @param  \App\Models\Products  $product
     * @return void
     */
    public function restored(Products $product)
    {
        //
    }

    /**
     * Handle the Products "force deleted" event.
     *
     * @param  \App\Models\Products  $product
     * @return void
     */
    public function forceDeleted(Products $product)
    {
        //
    }
}
