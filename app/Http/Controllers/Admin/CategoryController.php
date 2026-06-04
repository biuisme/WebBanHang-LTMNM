<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category-list', compact('categories'));
    }

    public function create()
    {
        return view('admin.category-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công');
    }

    public function show(Category $category)
    {
        return view('admin.category-show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.category-edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công');
    }
}
