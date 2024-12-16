<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    use HasFactory;

    protected $fillable = ['category_name'];

    public function discounts()
    {
        return $this->hasMany(Discounts::class, 'category_discount_id');
    }
}
