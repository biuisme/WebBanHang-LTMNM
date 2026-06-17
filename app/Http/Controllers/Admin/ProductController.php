<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
    	$products = Product::with('category')->latest()->paginate(10);
    	return view('admin.product-list', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product-create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imageName = 'default.png';
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
        }

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        AuditLog::create([
            'actor_id' => Auth::id(),
            'actor_name' => Auth::user()->name,
            'actor_email' => Auth::user()->email,
            'actor_role' => Auth::user()->role,
            'action' => 'created',
            'subject_type' => 'Product',
            'subject_id' => $product->id,
            'subject_name' => $product->name,
            'description' => 'Thêm sản phẩm mới: ' . $product->name,
            'new_values' => $product->toArray(),
            'ip_address' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.product-edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        $oldValues = $product->toArray();

        $imageName = $product->image;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        AuditLog::create([
            'actor_id' => Auth::id(),
            'actor_name' => Auth::user()->name,
            'actor_email' => Auth::user()->email,
            'actor_role' => Auth::user()->role,
            'action' => 'updated',
            'subject_type' => 'Product',
            'subject_id' => $product->id,
            'subject_name' => $product->name,
            'description' => 'Cập nhật sản phẩm: ' . $product->name,
            'old_values' => $oldValues,
            'new_values' => $product->toArray(),
            'ip_address' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function destroy(Request $request, Product $product)
    {
        $oldValues = $product->toArray();
        $productName = $product->name;
        $productId = $product->id;

        $product->delete();

        AuditLog::create([
            'actor_id' => Auth::id(),
            'actor_name' => Auth::user()->name,
            'actor_email' => Auth::user()->email,
            'actor_role' => Auth::user()->role,
            'action' => 'deleted',
            'subject_type' => 'Product',
            'subject_id' => $productId,
            'subject_name' => $productName,
            'description' => 'Xóa sản phẩm: ' . $productName,
            'old_values' => $oldValues,
            'ip_address' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    }
}