@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow border-0" style="border-left: 5px solid #696cff !important;">
            <div class="card-body">
                <h5 class="text-muted">Tổng sản phẩm</h5>
                <h2 class="fw-bold">{{ $tongSanPham }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow border-0" style="border-left: 5px solid #03c3ec !important;">
            <div class="card-body">
                <h5 class="text-muted">Đơn hàng</h5>
                <h2 class="fw-bold">45</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow border-0" style="border-left: 5px solid #ffab00 !important;">
            <div class="card-body">
                <h5 class="text-muted">Doanh thu</h5>
                <h2 class="fw-bold">18.500.000đ</h2>
            </div>
        </div>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body">
        <h3>Chào mừng Admin 🎉</h3>
        <p class="text-muted">
            Hệ thống quản lý Shop Phụ Kiện đang hoạt động bình thường.
        </p>
    </div>
</div>

@endsection
