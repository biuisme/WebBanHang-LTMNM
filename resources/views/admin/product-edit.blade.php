@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')

@section('content')

<div class="card card-custom">
    <div class="card-header bg-white">
        <h4 class="mb-0">Sửa sản phẩm</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Số lượng</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh hiện tại</label><br>
                <img src="{{ asset('uploads/products/' . $product->image) }}" width="100" style="border-radius:12px">
            </div>

            <div class="mb-3">
                <label class="form-label">Đổi ảnh mới</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-main">
                Cập nhật
            </button>

            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                Quay lại
            </a>
        </form>
    </div>
</div>

@endsection
