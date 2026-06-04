@extends('layouts.admin')

@section('title', 'Chi tiết tài khoản')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin chi tiết: {{ $user->name }}</h6>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th style="width: 200px;">ID tài khoản</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Tên hiển thị</th>
                        <td><span class="fw-bold">{{ $user->name }}</span></td>
                    </tr>
                    <tr>
                        <th>Địa chỉ Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Quyền truy cập</th>
                        <td>
                            @if($user->role == 1 || $user->role == 'admin')
                                <span class="badge bg-danger px-3 py-2">Quản trị viên (Admin)</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2">Khách hàng</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Ngày tạo</th>
                        <td>
                            {{ $user->created_at ? $user->created_at->format('d/m/Y - H:i') : 'Không xác định' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="mt-4">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning text-white">
                    <i class="bi bi-pencil-square"></i> Chỉnh sửa thông tin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
