<?php

namespace App\Http\Controllers;

use App\Models\Discounts;
use App\Models\ProductCategories;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ProductCategories::all();
        $products = Products::with('discounts')->get();

        return view('home', compact('categories', 'products'));
    }

    public function single($id)
    {
        $products = Products::findOrFail($id);
        $categories = ProductCategories::all();

        return view('single-product', compact('products', 'categories'));
    }
}
