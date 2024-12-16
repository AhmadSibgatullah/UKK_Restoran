<?php

namespace App\Http\Controllers;

use App\Models\DiscountCategories;
use Illuminate\Http\Request;

class DiscountCategoriesController extends Controller
{
    public function index()
    {
        $categories = DiscountCategories::all();
        return view('discount-categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100',
        ]);

        DiscountCategories::create($request->all());
        return redirect()->route('discount_categories.index')->with('success', 'Berhasil membuat kategori diskon');
    }

    public function edit($id)
    {
        $category = DiscountCategories::findOrFail($id);
        return view('discount_categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:100',
        ]);

        $category = DiscountCategories::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('discount_categories.index')->with('success', 'Berhasil memperbarui kategori diskon');
    }

    public function destroy($id)
    {
        $category = DiscountCategories::findOrFail($id);
        $category->delete();

        return redirect()->route('discount_categories.index')->with('success', 'Berhasil menghapus kategori diskon');
    }
}
