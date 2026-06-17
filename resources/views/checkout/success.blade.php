@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body text-center p-5">
                        @if(session('success'))
                            <div class="mb-4">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                            </div>
                            <h2 class="fw-bold text-success mb-3">{{ session('success') }}</h2>
                        @else
                            <div class="mb-4">
                                <i class="bi bi-info-circle-fill text-primary" style="font-size: 5rem;"></i>
                            </div>
                            <h2 class="fw-bold text-primary mb-3">Chi tiết đơn hàng #{{ $order->id }}</h2>
                        @endif

                        <p class="fs-5 mb-4">Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>

                        <div class="alert alert-light border shadow-sm text-start p-4 mb-4">
                            <h5 class="fw-bold border-bottom pb-2 mb-3">Thông tin đơn hàng</h5>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Mã đơn hàng:</div>
                                <div class="col-sm-8 fw-bold">#{{ $order->id }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Người nhận:</div>
                                <div class="col-sm-8">{{ $order->user->name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Địa chỉ giao:</div>
                                <div class="col-sm-8">{{ $order->shipping_address }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Số điện thoại:</div>
                                <div class="col-sm-8">{{ $order->phone }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Tổng tiền:</div>
                                <div class="col-sm-8 fw-bold text-danger">{{ number_format($order->total_amount) }} đ</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4 text-muted">Phương thức:</div>
                                <div class="col-sm-8 fw-bold text-primary">
                                    @if($order->payment_method == 'cod')
                                        Thanh toán khi nhận hàng (COD)
                                    @elseif($order->payment_method == 'bank_transfer')
                                        Chuyển khoản (VietQR)
                                    @elseif($order->payment_method == 'card')
                                        Thanh toán bằng thẻ
                                    @else
                                        {{ $order->payment_method }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($order->payment_method == 'bank_transfer')
                            <div class="card border-primary mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white fw-bold">
                                    Hướng dẫn chuyển khoản
                                </div>
                                <div class="card-body bg-light">
                                    <p class="mb-3">Vui lòng quét mã QR dưới đây qua App ngân hàng để thanh toán nhanh:</p>

                                    @php
                                        // Thông tin tài khoản ngân hàng (Thay đổi bằng thông tin thật của bạn)
                                        $bankId = 'MB'; // Tên viết tắt hoặc BIN của ngân hàng (Ví dụ: MB, VCB, TCB)
                                        $accountNo = '0987654321'; // Số tài khoản
                                        $accountName = 'NGUYEN VAN A'; // Tên chủ tài khoản
                                        $amount = $order->total_amount;
                                        $addInfo = 'Thanh toan don hang ' . $order->id; // Nội dung chuyển khoản

                                        // Tạo URL VietQR Quick Link
                                        $vietQrUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png?amount={$amount}&addInfo=" . urlencode($addInfo) . "&accountName=" . urlencode($accountName);
                                    @endphp

                                    <div class="bg-white p-3 d-inline-block rounded shadow-sm mb-3">
                                        <img src="{{ $vietQrUrl }}" alt="VietQR" class="img-fluid" style="max-width: 250px;">
                                    </div>

                                    <div class="text-start p-3 bg-white border rounded">
                                        <div class="row mb-2">
                                            <div class="col-sm-5 text-muted">Ngân hàng:</div>
                                            <div class="col-sm-7 fw-bold">{{ $bankId }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-5 text-muted">Số tài khoản:</div>
                                            <div class="col-sm-7 fw-bold text-primary">{{ $accountNo }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-5 text-muted">Chủ tài khoản:</div>
                                            <div class="col-sm-7 fw-bold">{{ $accountName }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-5 text-muted">Số tiền:</div>
                                            <div class="col-sm-7 fw-bold text-danger">{{ number_format($amount) }} VNĐ</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5 text-muted">Nội dung CK:</div>
                                            <div class="col-sm-7 fw-bold text-success">{{ $addInfo }}</div>
                                        </div>
                                    </div>

                                    <form action="{{ route('checkout.confirm_transfer', $order->id) }}" method="POST" class="mt-4">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm fw-bold rounded-pill">
                                            <i class="bi bi-check-circle me-2"></i> Xác nhận đã quét mã
                                        </button>
                                        <div class="text-muted mt-2 small">
                                            Vui lòng chỉ xác nhận sau khi bạn đã chuyển khoản thành công trên app ngân hàng.
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                        @if($order->payment_method != 'bank_transfer')
                        <div class="mt-4">
                            <a href="{{ url('/') }}" class="btn btn-outline-primary px-4 py-2 fw-bold">
                                <i class="bi bi-house-door"></i> Về trang chủ
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-primary px-4 py-2 fw-bold ms-2">
                                <i class="bi bi-box-seam"></i> Xem đơn hàng
                            </a>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection