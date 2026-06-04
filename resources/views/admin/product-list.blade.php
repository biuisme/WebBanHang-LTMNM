@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')

<div class="card card-custom">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h4 class="mb-0">
            Quản lý sản phẩm
        </h4>

<a href="{{ route('admin.products.create') }}" class="btn btn-main">
    <i class="bi bi-plus-circle"></i> Thêm sản phẩm
</a>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle table-hover">

                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th width="150">Thao tác</th>
                </tr>
                </thead>

               <tbody>

@foreach($products as $product)

<tr>

    <td>{{ $product->id }}</td>

    <td>
        <img
            src="{{ asset('uploads/products/' . $product->image) }}"
            width="70">
    </td>

    <td>
        {{ $product->name }}
    </td>

    <td>
        {{ $product->category->name ?? 'Không có danh mục' }}
    </td>

    <td>
        {{ number_format($product->price, 0, ',', '.') }}đ
    </td>

    <td>
        <span class="badge bg-success">
            Đang bán
        </span>
    </td>

    <td>

        <a href="{{ route('admin.products.edit', $product->id) }}"
           class="btn btn-warning btn-sm">
            <i class="bi bi-pencil"></i>
        </a>

        <form
            action="{{ route('admin.products.destroy', $product->id) }}"
            method="POST"
            style="display:inline-block">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                class="btn btn-danger btn-sm">

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

</div>

@endsection
