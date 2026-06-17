<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Admin Shop Phụ Kiện</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background:#f5f6fb;
            font-family:"Segoe UI",sans-serif;
        }

        .sidebar{
            width:270px;
            min-height:100vh;
            background:linear-gradient(180deg,#2b2d42,#1d1f33);
            position:fixed;
            left:0;
            top:0;
            color:white;
            padding:25px 18px;
        }

        .sidebar .brand{
            font-size:22px;
            font-weight:800;
            margin-bottom:35px;
            line-height:1.4;
        }

        .sidebar a{
            color:#cfd3ff;
            text-decoration:none;
            display:flex;
            align-items:center;
            gap:12px;
            padding:13px 16px;
            border-radius:14px;
            margin-bottom:10px;
            font-weight:600;
            transition:.3s;
        }

        .sidebar a:hover,
        .sidebar a.active{
            background:#696cff;
            color:white;
        }

        .sidebar .menu-title{
            color:#8f95c7;
            font-size:13px;
            margin:25px 0 12px;
            text-transform:uppercase;
            font-weight:700;
        }

        .main{
            margin-left:270px;
            padding:28px;
        }

        .topbar{
            background:white;
            border-radius:18px;
            padding:18px 24px;
            box-shadow:0 8px 24px rgba(0,0,0,.06);
            margin-bottom:28px;
        }

        .search-box{
            border:none;
            outline:none;
            width:100%;
            font-size:16px;
        }

        /* CSS CHUẨN CHO NÚT ĐĂNG XUẤT */
        .btn-logout {
            background: transparent; 
            border: none; 
            width: 100%; 
            text-align: left; 
            padding: 13px 16px; 
            color: #ff3e1d; 
            font-weight: 600; 
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            border-radius: 14px;
            transition: .3s;
        }
        .btn-logout:hover {
            background: rgba(255, 62, 29, 0.1);
        }

        @media(max-width:768px){
            .sidebar{
                position:relative;
                width:100%;
                min-height:auto;
            }
            .main{
                margin-left:0;
            }
        }
    </style>
</head>

<body>

<div class="sidebar">

    <div class="brand">
        <i class="bi bi-shop"></i>
        ADMIN SHOP<br>
        PHỤ KIỆN
    </div>

    <a href="{{ route('admin.dashboard') }}"
       class="{{ Request::is('admin') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        Tổng quan
    </a>

    <div class="menu-title">
        Quản trị dữ liệu
    </div>

    <a href="{{ route('admin.orders.index') }}"
        class="{{ Request::is('admin/orders*') ? 'active' : '' }}">
        <i class="bi bi-bag-check"></i>
        Quản lý đơn hàng
    </a>

    <a href="{{ route('admin.products.index') }}"
       class="{{ Request::is('admin/products*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i>
        Sản phẩm
    </a>

    <a href="{{ route('admin.categories.index') }}"
       class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
        <i class="bi bi-tags"></i>
        Danh mục
    </a>

    <a href="{{ route('admin.users.index') }}"
       class="{{ Request::is('admin/users*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        Tài khoản
    </a>

    <a href="{{ route('admin.audit-logs.index') }}"
       class="{{ Request::is('admin/audit-logs*') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i>
        Lịch sử hoạt động
    </a>

    <div style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 20px; padding-top: 10px;"></div>
            
    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="bi bi-box-arrow-right" style="font-size: 1.1rem;"></i> Đăng xuất
        </button>
    </form>

</div>

<div class="main">

    <div class="topbar d-flex align-items-center gap-3">
        <i class="bi bi-search fs-5 text-muted"></i>
        <input class="search-box" type="text" placeholder="Bạn muốn tìm chuột, bàn phím, tai nghe...">
    </div>

    @yield('content')

    <div class="text-center text-muted mt-4">
        Quản trị Shop Phụ Kiện
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
