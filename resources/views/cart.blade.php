@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">🛒 Giỏ hàng của bạn</h2>



    @if(session('cart') && count(session('cart')) > 0)
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered table-hover shadow-sm align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th style="width: 120px;">Số lượng</th>
                            <th>Thành tiền</th>
                            <th style="width: 80px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $itemTotal = $details['price'] * $details['quantity']; $total += $itemTotal; @endphp
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset('uploads/products/' . $details['image']) }}" alt="{{ $details['name'] }}" style="width: 80px; height: 80px; object-fit: cover;" class="rounded">
                                </td>
                                <td>
                                    <a href="{{ route('product.detail', $id) }}" class="text-decoration-none fw-bold">
                                        {{ $details['name'] }}
                                    </a>
                                </td>
                                <td class="text-danger fw-bold text-end">{{ number_format($details['price']) }} đ</td>
                                <td class="text-center">
                                    <div class="input-group input-group-sm" style="width: 100px; margin: 0 auto;">
                                        <input type="number" class="form-control" name="quantities[{{ $id }}]" value="{{ $details['quantity'] }}" min="0" max="999">
                                    </div>
                                </td>
                                <td class="text-danger fw-bold text-end">{{ number_format($itemTotal) }} đ</td>
                                <td class="text-center">
                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                        <i class="bi bi-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fw-bold fs-5">Tổng cộng:</td>
                            <td class="text-danger fw-bold fs-5 text-end">{{ number_format($total) }} đ</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Nút hành động -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <a href="{{ url('/') }}" class="btn btn-outline-primary flex-grow-1">
                            <i class="bi bi-arrow-left"></i> Tiếp tục mua hàng
                        </a>
                        <button type="submit" class="btn btn-warning flex-grow-1">
                            <i class="bi bi-arrow-clockwise"></i> Cập nhật
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                            <i class="bi bi-trash"></i> Xóa tất cả
                        </a>
                        <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg">
                            <i class="bi bi-credit-card"></i> Tiến hành thanh toán ({{ number_format($total) }} đ)
                        </a>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-bag" style="font-size: 3rem;"></i>
            <h4 class="mt-3 text-muted">Giỏ hàng của bạn đang trống!</h4>
            <p class="text-muted">Hãy thêm một vài sản phẩm để tiếp tục</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                <i class="bi bi-shop"></i> Mua sắm ngay
            </a>
        </div>
    @endif
</div>

<style>
    .table-responsive {
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .btn-group-vertical .btn {
        border-radius: 0.375rem;
    }

    input[type="number"] {
        text-align: center;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
