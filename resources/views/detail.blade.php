@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <img src="{{ asset('uploads/products/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="object-fit: cover; height: 400px;">
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-7">
            <div class="card border-0">
                <div class="card-body">
                    <!-- Tên sản phẩm -->
                    <h1 class="card-title fw-bold mb-3">{{ $product->name }}</h1>

                    <!-- Danh mục -->
                    @if($product->category)
                        <p class="text-muted">
                            <span class="badge bg-info">{{ $product->category->name }}</span>
                        </p>
                    @endif

                    <!-- Giá -->
                    <div class="mb-4">
                        <h3 class="text-danger fw-bold">{{ number_format($product->price) }} đ</h3>
                        <p class="text-muted">
                            @if($product->quantity > 0)
                                <span class="badge bg-success">Còn hàng ({{ $product->quantity }} sản phẩm)</span>
                            @else
                                <span class="badge bg-danger">Hết hàng</span>
                            @endif
                        </p>
                    </div>

                    <!-- Mô tả sản phẩm -->
                    <div class="mb-4">
                        <h5 class="fw-bold">Mô tả chi tiết:</h5>
                        <p class="text-justify" style="line-height: 1.8;">{{ $product->description }}</p>
                    </div>

                    <!-- Thông số kỹ thuật -->
                    <div class="mb-4">
                        <h5 class="fw-bold">Thông số sản phẩm:</h5>
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Tên sản phẩm</td>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Giá bán</td>
                                    <td class="text-danger fw-bold">{{ number_format($product->price) }} đ</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Danh mục</td>
                                    <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tồn kho</td>
                                    <td>{{ $product->quantity }} sản phẩm</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Ngày tạo</td>
                                    <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Nút hành động -->
                    <div class="d-grid gap-2 d-md-flex mb-3">
                        @if($product->quantity > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="GET" class="flex-grow-1">
                                <button type="submit" class="btn btn-primary w-100" name="action" value="add">
                                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                                </button>
                            </form>
                            <form action="{{ route('cart.add', $product->id) }}" method="GET" class="flex-grow-1">
                                <button type="submit" class="btn btn-success w-100" name="buy_now" value="1">
                                    <i class="bi bi-lightning-charge"></i> Mua ngay
                                </button>
                            </form>
                        @else
                            <button class="btn btn-danger w-100" disabled>
                                <i class="bi bi-x-circle"></i> Sản phẩm đã hết
                            </button>
                        @endif
                    </div>

                    <!-- Chia sẻ -->
                    <div class="border-top pt-3">
                        <p class="text-muted mb-2">Chia sẻ sản phẩm:</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-facebook"></i> Facebook
                        </a>
                        <a href="#" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-twitter"></i> Twitter
                        </a>
                        <a href="#" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-pinterest"></i> Pinterest
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm liên quan -->
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="fw-bold mb-4">Sản phẩm liên quan</h4>
        </div>
        @if($product->category)
            @php
                $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->limit(4)
                    ->get();
            @endphp
            
            @forelse($relatedProducts as $related)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-shadow">
                        <img src="{{ asset('uploads/products/' . $related->image) }}" class="card-img-top" alt="{{ $related->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold text-truncate-2">{{ $related->name }}</h6>
                            <p class="card-text text-danger fw-bold mb-auto">{{ number_format($related->price) }} đ</p>
                            <a href="{{ route('product.detail', $related->id) }}" class="btn btn-sm btn-outline-primary mt-2">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Không có sản phẩm liên quan</p>
                </div>
            @endforelse
        @endif
    </div>
</div>

<style>
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .hover-shadow {
        transition: box-shadow 0.3s ease;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
</style>
@endsection
