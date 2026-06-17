<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer,card',
            'note' => 'nullable|string',
            'card_number' => ['nullable', 'required_if:payment_method,card', 'regex:/^[0-9]{16}$/'],
            'expiry_date' => ['nullable', 'required_if:payment_method,card', 'regex:/^(0[1-9]|1[0-2])\/?([0-9]{2})$/'],
            'cvv' => ['nullable', 'required_if:payment_method,card', 'regex:/^[0-9]{3}$/']
        ], [
            'card_number.required_if' => 'Vui lòng nhập số thẻ.',
            'card_number.regex' => 'Số thẻ phải gồm đúng 16 chữ số.',
            'expiry_date.required_if' => 'Vui lòng nhập ngày hết hạn.',
            'expiry_date.regex' => 'Ngày hết hạn phải theo định dạng MM/YY.',
            'cvv.required_if' => 'Vui lòng nhập mã CVV.',
            'cvv.regex' => 'Mã CVV phải gồm đúng 3 chữ số.'
        ]);

        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $status = in_array($request->payment_method, ['cod', 'card']) ? 'confirmed' : 'pending';

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => $status,
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'note' => $request->note,
            'payment_method' => $request->payment_method
        ]);

        // Tạo chi tiết đơn hàng
        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $details['name'],
                'price' => $details['price'],
                'quantity' => $details['quantity']
            ]);
        }

        // Làm trống giỏ hàng
        session()->forget('cart');

        return redirect()->route('checkout.success', $order->id)->with('success', 'Đặt hàng thành công!');
    }

    public function success(Order $order)
    {
        // Đảm bảo chỉ người đặt hàng mới được xem
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    public function confirmTransfer(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Cập nhật trạng thái thành 'confirmed' (đã duyệt thành công)
        $order->status = 'confirmed';
        $order->save();

        return redirect()->route('checkout.transfer_success', $order->id);
    }

    public function transferSuccess(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.transfer_success', compact('order'));
    }
}
