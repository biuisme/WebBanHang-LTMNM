@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="bi bi-patch-check-fill text-success" style="font-size: 6rem;"></i>
                    </div>
                    <h2 class="fw-bold text-success mb-3">Chuyển khoản thành công!</h2>
                    
                    <p class="fs-5 text-muted mb-4">
                        Hệ thống đã ghi nhận xác nhận chuyển khoản của bạn cho đơn hàng <strong>#{{ $order->id }}</strong>.
                    </p>
                    
                    <div class="alert alert-light border shadow-sm text-start p-4 mb-4">
                        <p class="mb-2">
                            <i class="bi bi-info-circle text-primary me-2"></i> 
                            Nhân viên của chúng tôi sẽ kiểm tra đối soát giao dịch và tiến hành xác nhận đơn hàng của bạn trong thời gian sớm nhất.
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-envelope text-primary me-2"></i> 
                            Bạn có thể theo dõi trạng thái đơn hàng tại mục <strong>Đơn hàng của tôi</strong>.
                        </p>
                    </div>

                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="btn btn-outline-primary px-4 py-2 fw-bold">
                            <i class="bi bi-house-door"></i> Về trang chủ
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-primary px-4 py-2 fw-bold ms-2">
                            <i class="bi bi-box-seam"></i> Quản lý đơn hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
