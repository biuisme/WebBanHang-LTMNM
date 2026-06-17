<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Thứ tự trạng thái — không được đi ngược
    const STATUS_FLOW = [
        'pending'   => 0,
        'confirmed' => 1,
        'shipping'  => 2,
        'completed' => 3,
        'cancelled' => 99, // đặc biệt, chỉ từ pending/confirmed
    ];

    public function index(Request $request)
    {
        $query = Order::with('user')->orderBy('created_at', 'desc');

        // Lọc theo trạng thái nếu có
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,completed,cancelled',
        ]);

        $newStatus  = $request->status;
        $curStatus  = $order->status;
        $flow       = self::STATUS_FLOW;

        // Không cho phép đổi nếu đã completed hoặc cancelled
        if (in_array($curStatus, ['completed', 'cancelled'])) {
            return back()->with('error', 'Đơn hàng đã kết thúc, không thể thay đổi trạng thái.');
        }

        // Không cho đi ngược
        if ($newStatus !== 'cancelled' && $flow[$newStatus] < $flow[$curStatus]) {
            return back()->with('error', 'Không thể chuyển ngược trạng thái đơn hàng.');
        }

        // Chỉ cho hủy khi còn pending hoặc confirmed
        if ($newStatus === 'cancelled' && !in_array($curStatus, ['pending', 'confirmed'])) {
            return back()->with('error', 'Chỉ có thể hủy đơn khi đang ở trạng thái chờ xác nhận hoặc đã xác nhận.');
        }

        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Cập nhật trạng thái thành công.');
    }
}