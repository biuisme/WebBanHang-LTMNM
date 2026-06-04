@extends('layouts.admin')

@section('title', 'Tổng quan')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Chào mừng Quản trị viên! 🎉</h5>
                        <p class="mb-4">
                            Hệ thống quản trị chạy trên nền tảng Laravel đang hoạt động cục bộ ổn định.
                        </p>
                        <a href="{{ url('/admin/products') }}" class="btn btn-sm btn-outline-primary">Xem kho hàng ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
</div>
<li style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 20px; padding-top: 10px; list-style: none;"></li>
            
            <li style="list-style: none;">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: transparent; border: none; width: 100%; text-align: left; padding: 12px 15px; color: #ff3e1d; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 15px; border-radius: 8px;">
                        <i class="bi bi-box-arrow-right" style="font-size: 1.1rem;"></i> Đăng xuất
                    </button>
                </form>
            </li>
@endsection
