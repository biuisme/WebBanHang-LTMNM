@extends('layouts.admin')

@section('title', 'Danh sách danh mục')

@section('content')

<div class="card card-custom">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Quản lý danh mục</h4>

        <a href="{{ route('admin.categories.create') }}" class="btn btn-main">
            <i class="bi bi-plus-circle"></i> Thêm danh mục
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th width="180">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')

                                <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
