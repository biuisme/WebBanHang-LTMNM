<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tài khoản - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* GIỮ NGUYÊN CSS NHƯ CŨ */
        body { background-color: #f4f5f8; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { width: 260px; height: 100vh; background-color: #232333; position: fixed; top: 0; left: 0; color: #fff; padding-top: 20px; z-index: 100;}
        .sidebar-brand { font-size: 1.1rem; font-weight: 800; padding: 0 20px 20px 20px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 20px; letter-spacing: 0.5px;}
        .sidebar-menu { list-style: none; padding: 0 15px; margin: 0; }
        .sidebar-heading { font-size: 0.75rem; color: #a3a4cc; padding: 15px 15px 10px 15px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;}
        .menu-item { margin-bottom: 5px; }
        .menu-link { color: #a3a4cc; text-decoration: none; display: flex; align-items: center; gap: 15px; padding: 12px 15px; border-radius: 8px; transition: all 0.3s; font-weight: 500;}
        .menu-link:hover { color: #fff; background-color: rgba(255,255,255,0.05); }
        .menu-item.active .menu-link { background-color: #696cff; color: #fff; box-shadow: 0 2px 6px 0 rgba(105, 108, 255, 0.4); }
        .main-content { margin-left: 260px; padding: 25px 35px; }
        .admin-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 6px 0 rgba(67, 89, 113, 0.04); padding: 30px; border: none; }
        .card-title { font-size: 1.3rem; font-weight: 600; color: #32475c; margin-bottom: 20px; }
        .form-label { font-weight: 600; color: #32475c; font-size: 0.95rem; }
        .form-control, .form-select { border-radius: 8px; padding: 10px 15px; border: 1px solid #d9dee3; color: #697a8d; }
        .form-control:focus, .form-select:focus { border-color: #696cff; box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1); }
        .btn-save { background-color: #696cff; color: white; border: none; border-radius: 8px; padding: 10px 25px; font-weight: 500; }
        .btn-save:hover { background-color: #5f61e6; color: white; }
        .btn-cancel { background-color: #8592a3; color: white; border: none; border-radius: 8px; padding: 10px 25px; font-weight: 500; text-decoration: none; }
        .btn-cancel:hover { background-color: #717c8b; color: white; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-shop" style="font-size: 1.5rem;"></i> <span>ADMIN SHOP<br>PHỤ KIỆN</span>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-item"><a href="{{ route('admin.dashboard') }}" class="menu-link"><i class="bi bi-speedometer2"></i> Tổng quan</a></li>
            <div class="sidebar-heading">QUẢN TRỊ DỮ LIỆU</div>
            <li class="menu-item"><a href="{{ route('admin.products.index') }}" class="menu-link"><i class="bi bi-box-seam"></i> Sản phẩm</a></li>
            <li class="menu-item"><a href="{{ route('admin.categories.index') }}" class="menu-link"><i class="bi bi-tags"></i> Danh mục</a></li>
            <li class="menu-item active"><a href="{{ route('admin.users.index') }}" class="menu-link"><i class="bi bi-people"></i> Tài khoản</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="admin-card">
            <h4 class="card-title">Thêm Tài Khoản Mới</h4>
            
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" name="name" placeholder="Nhập họ tên" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Địa chỉ Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Nhập email" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu (tối thiểu 8 ký tự)" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Quyền truy cập</label>
                        <select class="form-select" name="role">
                            <option value="user">Khách hàng</option>
                            <option value="admin">Quản trị viên (Admin)</option>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> Lưu tài khoản</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-cancel"><i class="bi bi-x-lg"></i> Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
