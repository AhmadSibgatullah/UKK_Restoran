<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlists;
use Illuminate\Support\Facades\Auth;

class WishlistsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $customer = Auth::guard('customers')->user(); // Mendapatkan customer yang sedang login

        if (!$customer) {
            return redirect()->back()->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah produk sudah ada di wishlist
        $existingWishlist = Wishlists::where('customer_id', $customer->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingWishlist) {
            return redirect()->back()->with('message', 'Produk sudah ada di wishlist.');
        }

        // Tambahkan ke wishlist
        Wishlists::create([
            'customer_id' => $customer->id,
            'product_id' => $request->product_id,
        ]);

        return redirect()->back()->with('message', 'Produk berhasil ditambahkan ke wishlist.');
    }
}
