<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shop Phụ Kiện Máy Tính</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    Shop Phụ Kiện
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Danh Mục Phụ Kiện
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach(\App\Models\Category::all() as $cat)
                                    <li><a class="dropdown-item" href="{{ route('category.show', $cat->id) }}">{{ $cat->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex mx-auto w-50" action="{{ route('search') }}" method="GET">
                        <input class="form-control me-2" type="search" name="tukhoa" placeholder="Bạn muốn tìm chuột, bàn phím..." required>
                        <button class="btn btn-outline-success" type="submit">Tìm</button>
                    </form>
                    
                    <ul class="navbar-nav ms-auto d-flex align-items-center flex-row">
                        <ul class="navbar-nav ms-auto d-flex align-items-center flex-row">
                        
                        <li class="nav-item me-3" style="list-style: none;">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-success d-flex align-items-center">
                                <i class="bi bi-cart3 me-1"></i> Giỏ hàng
                                <span class="badge bg-danger rounded-pill ms-2">
                                    {{ session('cart') ? count(session('cart')) : 0 }}
                                </span>
                            </a>
                        </li>

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item me-2">
                                    <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item me-3" style="list-style: none;">
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-success d-flex align-items-center">
                                    <i class="bi bi-cart3 me-1"></i> Giỏ hàng
                                    <span class="badge bg-danger rounded-pill ms-2">
                                        {{ session('cart') ? count(session('cart')) : 0 }}
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item dropdown" style="list-style: none;">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Xin chào, {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="position: absolute;">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Đăng xuất
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
