@extends('layouts.admin')

@section('title', 'Quản lý Tài khoản')

@section('content')
<style>
    .admin-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.04); padding: 30px; border: none; }
    .card-header-custom { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .card-title { font-size: 1.3rem; font-weight: 600; color: #32475c; margin: 0; }
    .btn-add { background-color: #696cff; color: white; border: none; border-radius: 8px; padding: 10px 20px; font-weight: 500; transition: 0.3s; font-size: 0.9rem;}
    .btn-add:hover { background-color: #5f61e6; color: white; }
    
    .table { color: #697a8d; margin-bottom: 0;}
    .table th { border-bottom: 1px solid #d9dee3; color: #32475c; font-weight: 700; padding: 15px 10px; font-size: 0.9rem;}
    .table td { padding: 15px 10px; vertical-align: middle; border-bottom: 1px solid #ebeef0; font-size: 0.95rem;}
    
    .btn-action { width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; border: none; margin-right: 5px; color: white; font-size: 0.9rem;}
    .btn-delete { background-color: #ff3e1d; }
    .btn-action:hover { opacity: 0.85; color: white;}
</style>

<div class="admin-card mt-2">
    <div class="card-header-custom">
        <h4 class="card-title">Quản lý tài khoản</h4>
        <button class="btn btn-add"><i class="bi bi-plus-circle"></i> Thêm tài khoản</button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th>Tên tài khoản</th>
                    <th>Email</th>
                    <th>Quyền truy cập</th>
                    <th width="15%">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td class="text-dark fw-medium">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin' || $user->role == 1)
                            <span style="color: #ff3e1d; background: rgba(255, 62, 29, 0.1); padding: 5px 10px; border-radius: 5px; font-size: 0.85rem; font-weight: 600;">Admin</span>
                        @else
                            <span style="color: #697a8d; background: #f0f2f4; padding: 5px 10px; border-radius: 5px; font-size: 0.85rem; font-weight: 600;">Khách hàng</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm text-white" title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm text-white" title="Sửa">
                                <i class="bi bi-pencil-square"></i> 
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Xóa"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
