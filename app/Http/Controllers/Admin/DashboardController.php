<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $tongSanPham = Product::count();
        $tongDonHang = Order::count();

        $doanhThu = Order::where('status', 'completed')->sum('total_amount');

        $donHangGanNhat = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $doanhThuTheoThang = Order::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as thang, SUM(total_amount) as tong')
            ->groupBy('thang')
            ->orderBy('thang')
            ->get()
            ->keyBy('thang');

        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueData[] = $doanhThuTheoThang->has($i)
                ? (int) $doanhThuTheoThang[$i]->tong
                : 0;
        }

        return view('admin.dashboard', compact(
            'tongSanPham',
            'tongDonHang',
            'doanhThu',
            'donHangGanNhat',
            'revenueData'
        ));
    }
}