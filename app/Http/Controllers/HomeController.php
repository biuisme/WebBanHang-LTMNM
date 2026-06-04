<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    // Hiển thị Trang chủ (Có phân trang)
    public function index()
    {
        $products = Product::latest()->paginate(8);
        
        return view('home', compact('products'));
    }

    // Xem chi tiết 1 sản phẩm
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('detail', compact('product'));
    }

    // Hàm Lọc sản phẩm theo danh mục
    public function category($id)
    {
        // Lấy tên danh mục đang chọn để hiển thị ra View
        $category = Category::findOrFail($id);
        
        // Lấy các sản phẩm có category_id khớp với danh mục này (mỗi trang 8 cái)
        $products = Product::where('category_id', $id)->paginate(8);
        
        return view('home', compact('products', 'category'));
    }

    // Chức năng Tìm kiếm
    public function search(Request $request)
    {
        $keyword = $request->input('tukhoa');
        $products = Product::where('name', 'LIKE', "%{$keyword}%")->paginate(8);
        return view('home', compact('products'));
    }
}
