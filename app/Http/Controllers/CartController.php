<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }
        
        return view('cart', compact('cart', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "id" => $product->id,
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

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
        
        return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
    }

    /**
     * Cập nhật số lượng sản phẩm
     */
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if($request->has('quantities')) {
            foreach($request->quantities as $id => $quantity) {
                if(isset($cart[$id])) {
                    if($quantity > 0) {
                        $cart[$id]['quantity'] = $quantity;
                    } else {
                        unset($cart[$id]);
                    }
                }
            }
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được làm trống!');
    }
}
