<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'product_name',
        'description',
        'price',
        'stock_quantity',
        'image1_url',
        'image2_url',
        'image3_url',
        'image4_url',
        'image5_url',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategories::class, 'product_category_id');
    }

    public function discounts()
    {
        return $this->hasOne(Discounts::class, 'product_id');
    }
}
