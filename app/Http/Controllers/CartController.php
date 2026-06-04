<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 

class CartController extends Controller
{
    
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        if (request()->has('buy_now')) {
            // Chuyển thẳng sang trang Giỏ hàng
            return redirect()->route('cart.index')->with('success', 'Đã thêm ' . $product->name . ' vào giỏ hàng!');
        }

        // Mặc định (Khách bấm "Thêm vào giỏ"): Quay lại trang cũ
        return redirect()->back()->with('success', 'Đã thêm ' . $product->name . ' vào giỏ hàng!');
    }
}
