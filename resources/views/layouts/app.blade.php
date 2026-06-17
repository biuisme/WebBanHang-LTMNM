<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shop Phụ Kiện Máy Tính</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold"
                   href="{{ route('home') }}">
                    Shop Phụ Kiện
                </a>

                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Mở menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse"
                     id="navbarSupportedContent">

                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('home') }}">
                                Trang chủ
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"
                               href="#"
                               id="categoryDropdown"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                Danh mục phụ kiện
                            </a>

                            <ul class="dropdown-menu"
                                aria-labelledby="categoryDropdown">
                                @forelse(\App\Models\Category::all() as $cat)
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('category.show', $cat->id) }}">
                                            {{ $cat->name }}
                                        </a>
                                    </li>
                                @empty
                                    <li>
                                        <span class="dropdown-item-text text-muted">
                                            Chưa có danh mục
                                        </span>
                                    </li>
                                @endforelse
                            </ul>
                        </li>
                    </ul>

                    <form class="d-flex mx-md-auto my-3 my-md-0"
                          action="{{ route('search') }}"
                          method="GET"
                          style="width: min(100%, 500px);">

                        <input class="form-control me-2"
                               type="search"
                               name="tukhoa"
                               value="{{ request('tukhoa') }}"
                               placeholder="Bạn muốn tìm chuột, bàn phím..."
                               required>

                        <button class="btn btn-outline-success"
                                type="submit">
                            Tìm
                        </button>
                    </form>

                    <ul class="navbar-nav ms-auto align-items-md-center">
                        <li class="nav-item me-md-3">
                            <a href="{{ route('cart.index') }}"
                               class="btn btn-outline-success d-flex align-items-center mt-2 mt-md-0">

                                <i class="bi bi-cart3 me-1"></i>

                                Giỏ hàng

                                <span class="badge bg-danger rounded-pill ms-2">
                                    {{ session('cart') ? count(session('cart')) : 0 }}
                                </span>
                            </a>
                        </li>

                        @guest
                            @if(Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{ route('login') }}">
                                        Đăng nhập
                                    </a>
                                </li>
                            @endif

                            @if(Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{ route('register') }}">
                                        Đăng ký
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="accountDropdown"
                                   class="nav-link dropdown-toggle fw-bold"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    Xin chào, {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="accountDropdown">

                                    @if(Auth::user()->role === 'admin')
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('admin.dashboard') }}">
                                                <i class="bi bi-speedometer2 me-2"></i>
                                                Trang quản trị
                                            </a>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    @endif

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('orders.index') }}">
                                            <i class="bi bi-box-seam me-2"></i>
                                            Đơn hàng của tôi
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">

                                            <i class="bi bi-box-arrow-right me-2"></i>
                                            Đăng xuất
                                        </a>
                                    </li>
                                </ul>

                                <form id="logout-form"
                                      action="{{ route('logout') }}"
                                      method="POST"
                                      class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show"
                     role="alert">

                    <i class="bi bi-shield-exclamation me-2"></i>

                    <strong>Lỗi bảo mật!</strong>
                    {{ session('error') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Đóng">
                    </button>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show"
                     role="alert">

                    <i class="bi bi-check-circle me-2"></i>

                    {{ session('success') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Đóng">
                    </button>
                </div>
            </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
</body>
</html>
