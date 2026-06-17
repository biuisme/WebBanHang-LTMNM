@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">📦 Đơn hàng của tôi</h2>

            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm bg-white rounded">
                        <thead class="table-dark">
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Tổng tiền</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="fw-bold">#{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                        @elseif($order->status == 'confirmed')
                                            <span class="badge bg-info text-dark">Đã xác nhận</span>
                                        @elseif($order->status == 'shipping')
                                            <span class="badge bg-primary">Đang giao hàng</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-success">Hoàn thành</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger">Đã hủy</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->payment_method == 'cod')
                                            <span class="text-success"><i class="bi bi-cash-stack"></i> COD</span>
                                        @elseif($order->payment_method == 'bank_transfer')
                                            <span class="text-primary"><i class="bi bi-qr-code-scan"></i> VietQR</span>
                                        @elseif($order->payment_method == 'card')
                                            <span class="text-warning"><i class="bi bi-credit-card"></i> Thẻ</span>
                                        @else
                                            {{ $order->payment_method }}
                                        @endif
                                    </td>
                                    <td class="text-danger fw-bold">{{ number_format($order->total_amount) }} đ</td>
                                    <td class="text-center">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center p-5 shadow-sm">
                    <i class="bi bi-box-seam text-secondary mb-3" style="font-size: 4rem; display: block;"></i>
                    <h5 class="text-muted">Bạn chưa có đơn hàng nào!</h5>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Mua sắm ngay</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
