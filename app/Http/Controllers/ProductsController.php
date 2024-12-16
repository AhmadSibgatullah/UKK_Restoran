<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\ProductCategories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori dan produk dengan relasi kategori
        $categories = ProductCategories::all();
        $products = Products::with('category')->get();
        return view('products', compact('products', 'categories'));
    }

    public function create()
    {
        // Mengirimkan kategori ke view create
        $categories = ProductCategories::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'product_name' => 'required|max:100',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'image1_url' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image2_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image4_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image5_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Menyimpan gambar-gambar produk
            $imagePaths = [];
            for ($i = 1; $i <= 5; $i++) {
                $field = "image{$i}_url";
                if ($request->hasFile($field)) {
                    $imagePaths[$field] = $request->file($field)->store('products', 'public');
                } else {
                    $imagePaths[$field] = null;
                }
            }

            // Menyimpan produk ke dalam database
            DB::transaction(function () use ($request, $imagePaths) {
                Products::create(array_merge($request->except(['image1_url', 'image2_url', 'image3_url', 'image4_url', 'image5_url']), $imagePaths));
            });

            return redirect()->route('products.index')->with('success', 'Berhasil menambahkan produk!');
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }

    public function edit($id)
    {
        // Mengambil data produk dan kategori
        $products = Products::findOrFail($id);
        $categories = ProductCategories::all();
        return view('products', compact('products', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $products = Products::findOrFail($id);

        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'product_name' => 'required|max:100',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'image1_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image2_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image3_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image4_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image5_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Memproses gambar baru dan mempertahankan gambar lama jika tidak diunggah
            $imagePaths = [];
            for ($i = 1; $i <= 5; $i++) {
                $field = "image{$i}_url";
                if ($request->hasFile($field)) {
                    if ($products->{$field}) {
                        Storage::disk('public')->delete($products->{$field});
                    }
                    $imagePaths[$field] = $request->file($field)->store('products', 'public');
                } else {
                    $imagePaths[$field] = $products->{$field};
                }
            }

            $products->update(array_merge(
                $request->except(['image1_url', 'image2_url', 'image3_url', 'image4_url', 'image5_url']),
                $imagePaths
            ));

            return redirect()->route('products.index')->with('success', 'Berhasil memperbarui produk!');
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.'])->withInput();
        }
    }


    public function destroy($id)
    {
        $products = Products::findOrFail($id);

        try {
            $products->delete();
            return redirect()->route('products.index')->with('success', 'Berhasil menghapus produk!');
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }
}
