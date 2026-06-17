@extends('layouts.admin')
@section('title', 'Chỉnh sửa Tài khoản')
@section('content')

<div class="card shadow border-0">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4">Cập Nhật Tài Khoản</h5>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Họ và Tên</label>
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Địa chỉ Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Mật khẩu mới <span class="text-muted fw-normal">(Để trống nếu không đổi)</span></label>
                    <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu mới...">
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">Quyền truy cập</label>
                    <select class="form-select" name="role">
                        <option value="user"  {{ $user->role == 'user'  ? 'selected' : '' }}>Khách hàng</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-arrow-clockwise me-1"></i> Cập nhật
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-x-lg me-1"></i> Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>

@endsection