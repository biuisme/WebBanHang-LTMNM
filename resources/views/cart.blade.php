@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Giỏ hàng của bạn 🛒</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('cart'))
        <table class="table table-bordered table-hover shadow-sm text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                    <tr>
                        <td>
                            <img src="{{ asset('uploads/products/' . $details['image']) }}" alt="{{ $details['name'] }}" style="width: 80px; height: 80px; object-fit: cover;" class="rounded">
                        </td>
                        <td class="fw-bold">{{ $details['name'] }}</td>
                        <td class="text-danger">{{ number_format($details['price']) }} đ</td>
                        <td>{{ $details['quantity'] }}</td>
                        <td class="text-danger fw-bold">{{ number_format($details['price'] * $details['quantity']) }} đ</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end fw-bold fs-5">Tổng cộng:</td>
                    <td class="text-danger fw-bold fs-5">{{ number_format($total) }} đ</td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ url('/') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Tiếp tục mua hàng</a>
            <button class="btn btn-success"><i class="bi bi-credit-card"></i> Tiến hành thanh toán</button>
        </div>
    @else
        <div class="text-center py-5 shadow-sm rounded bg-white">
            <h4 class="text-muted">Giỏ hàng của bạn đang trống!</h4>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Mua sắm ngay</a>
        </div>
    @endif
</div>
@endsection
