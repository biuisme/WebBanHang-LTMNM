@extends('layouts.admin')

@section('title', 'Thêm danh mục')

@section('content')

<div class="card card-custom">
    <div class="card-header bg-white">
        <h4>Thêm danh mục</h4>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tên danh mục</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-main">Lưu</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>

@endsection
