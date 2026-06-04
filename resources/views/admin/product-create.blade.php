@extends('layouts.admin')

@section('title', 'Thêm sản phẩm')

@section('content')

<div class="card card-custom">
    <div class="card-header bg-white">
        <h4 class="mb-0">Thêm sản phẩm</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Số lượng</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh sản phẩm</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-main">
                Lưu sản phẩm
            </button>

            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                Quay lại
            </a>
        </form>
    </div>
</div>

@endsection
