<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\ProductCategories;

class MenuController extends Controller
{
    public function index()
    {
        $categories = ProductCategories::all();
        $products = Products::with('discounts')->get();

        return view('menu', compact('categories', 'products'));
    }

    public function single($id)
    {
        $products = Products::findOrFail($id);
        $categories = ProductCategories::all();
        $productsSingle = Products::findOrFail($id)->orderBy('id', 'desc')->paginate(4);

        return view('single-product', compact('products', 'categories', 'productsSingle'));
    }
}
