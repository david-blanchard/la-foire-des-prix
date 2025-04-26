<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product',
        'image',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function image()
    {
        return $this->belongsTo(Images::class);
    }

}

