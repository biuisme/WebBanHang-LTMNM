@extends('admin.index')

@section('content')
<div class="container-fluid py-4">

    {{-- Tiêu đề --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Chi tiết danh mục</h3>
            <p class="text-muted mb-0">
                Thông tin chi tiết của danh mục sản phẩm
            </p>
        </div>

        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Quay lại
        </a>
    </div>

    {{-- Thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show"
             role="alert">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-folder2-open me-2"></i>
                        Thông tin danh mục
                    </h5>
                </div>

                <div class="card-body p-4">

                    {{-- ID --}}
                    <div class="row border-bottom py-3">
                        <div class="col-md-4 fw-semibold text-muted">
                            Mã danh mục
                        </div>

                        <div class="col-md-8">
                            #{{ $category->id }}
                        </div>
                    </div>

                    {{-- Tên danh mục --}}
                    <div class="row border-bottom py-3">
                        <div class="col-md-4 fw-semibold text-muted">
                            Tên danh mục
                        </div>

                        <div class="col-md-8 fw-semibold">
                            {{ $category->name }}
                        </div>
                    </div>

                    {{-- Mô tả --}}
                    <div class="row border-bottom py-3">
                        <div class="col-md-4 fw-semibold text-muted">
                            Mô tả
                        </div>

                        <div class="col-md-8">
                            {{ $category->description ?: 'Chưa có mô tả' }}
                        </div>
                    </div>

                    {{-- Trạng thái, chỉ hiển thị nếu có cột status --}}
                    @if(isset($category->status))
                        <div class="row border-bottom py-3">
                            <div class="col-md-4 fw-semibold text-muted">
                                Trạng thái
                            </div>

                            <div class="col-md-8">
                                @if(
                                    $category->status == 1 ||
                                    $category->status === 'active'
                                )
                                    <span class="badge bg-success">
                                        Đang hoạt động
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Ngừng hoạt động
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Ngày tạo --}}
                    <div class="row border-bottom py-3">
                        <div class="col-md-4 fw-semibold text-muted">
                            Ngày tạo
                        </div>

                        <div class="col-md-8">
                            {{ $category->created_at
                                ? $category->created_at->format('d/m/Y H:i:s')
                                : 'Không xác định'
                            }}
                        </div>
                    </div>

                    {{-- Ngày cập nhật --}}
                    <div class="row py-3">
                        <div class="col-md-4 fw-semibold text-muted">
                            Cập nhật lần cuối
                        </div>

                        <div class="col-md-8">
                            {{ $category->updated_at
                                ? $category->updated_at->format('d/m/Y H:i:s')
                                : 'Không xác định'
                            }}
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white py-3">
                    <div class="d-flex flex-wrap gap-2">

                        <a href="{{ route('admin.categories.index') }}"
                           class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            Quay lại
                        </a>

                        <a href="{{ route(
                            'admin.categories.edit',
                            $category->id
                        ) }}"
                           class="btn btn-warning">
                            <i class="bi bi-pencil-square me-1"></i>
                            Chỉnh sửa
                        </a>

                        <form action="{{ route(
                                  'admin.categories.destroy',
                                  $category->id
                              ) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm(
                                  'Bạn có chắc chắn muốn xóa danh mục này?'
                              )">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>
                                Xóa danh mục
                            </button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
