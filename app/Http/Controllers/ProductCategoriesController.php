<?php

namespace App\Http\Controllers;

use App\Models\ProductCategories;
use Illuminate\Http\Request;

class ProductCategoriesController extends Controller
{
    public function index()
    {
        $categories = ProductCategories::all();
        return view('product-categories', compact('categories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        ProductCategories::create($request->all());

        return redirect()->route('product_categories.index')
            ->with('success', 'Berhasil membuat kategori baru');
    }

    public function edit($id)
    {
        $categories = ProductCategories::findOrFail($id);
        return view('product_categories.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $categories = ProductCategories::findOrFail($id);
        $categories->update($request->all());

        return redirect()->route('product_categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $categories = ProductCategories::findOrFail($id);
        $categories->delete();

        return redirect()->route('product_categories.index')
            ->with('success', 'Berhasil menghapus kategori');
    }
}
