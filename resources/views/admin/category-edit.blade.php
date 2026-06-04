@extends('layouts.admin')

@section('title', 'Sửa danh mục')

@section('content')

<div class="card card-custom">
    <div class="card-header bg-white">
        <h4>Sửa danh mục</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tên danh mục</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4">{{ $category->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-main">Cập nhật</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>

@endsection
