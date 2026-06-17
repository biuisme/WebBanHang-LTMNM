@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <!-- Cột thông tin đơn hàng -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light fw-bold">Thông tin giao hàng</div>
                <div class="card-body">
                    <p><strong>Người nhận:</strong> {{ $order->user->name }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Ghi chú:</strong> {{ $order->note ?: 'Không có' }}</p>
                    <hr>
                    <p><strong>Trạng thái:</strong> 
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
                    </p>
                    <p><strong>Thanh toán:</strong> 
                        @if($order->payment_method == 'cod')
                            Thanh toán khi nhận hàng (COD)
                        @elseif($order->payment_method == 'bank_transfer')
                            Chuyển khoản (VietQR)
                        @elseif($order->payment_method == 'card')
                            Thanh toán bằng thẻ
                        @else
                            {{ $order->payment_method }}
                        @endif
                    </p>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>

            @if($order->status == 'pending' && $order->payment_method == 'bank_transfer')
                <div class="card border-primary mt-4 shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">
                        Thanh toán đơn hàng
                    </div>
                    <div class="card-body bg-light text-center">
                        <p class="mb-3 small">Quét mã dưới đây để thanh toán cho đơn hàng này:</p>
                        
                        @php
                            $bankId = 'MB'; 
                            $accountNo = '0987654321'; 
                            $accountName = 'NGUYEN VAN A'; 
                            $amount = $order->total_amount;
                            $addInfo = 'Thanh toan don hang ' . $order->id; 
                            $vietQrUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png?amount={$amount}&addInfo=" . urlencode($addInfo) . "&accountName=" . urlencode($accountName);
                        @endphp

                        <div class="bg-white p-2 d-inline-block rounded shadow-sm mb-3">
                            <img src="{{ $vietQrUrl }}" alt="VietQR" class="img-fluid" style="max-width: 200px;">
                        </div>
                        
                        <form action="{{ route('checkout.confirm_transfer', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">
                                <i class="bi bi-check-circle me-1"></i> Xác nhận đã quét mã
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Cột danh sách sản phẩm -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light fw-bold">Sản phẩm đã mua</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('product.detail', $item->product_id) }}" class="text-decoration-none fw-bold">
                                            {{ $item->product_name }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end text-muted">{{ number_format($item->price) }} đ</td>
                                    <td class="text-end text-danger fw-bold">{{ number_format($item->price * $item->quantity) }} đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                    <td class="text-end text-danger fw-bold fs-5">{{ number_format($order->total_amount) }} đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
