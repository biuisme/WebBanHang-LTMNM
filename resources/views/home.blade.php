@extends('layouts.app')

@section('content')

<style>
    /* 1. Ẩn thẻ chữ Showing... */
    .phan-trang-custom p {
        display: none !important;
    }
    
    /* 2. Ẩn luôn cái hộp (div) bọc ngoài chữ để nó không chiếm chỗ */
    .phan-trang-custom .d-sm-flex.justify-content-sm-between > div:first-child {
        display: none !important;
    }
    
    /* 3. Ép thanh số nhảy ra chính giữa tuyệt đối */
    .phan-trang-custom .d-sm-flex.justify-content-sm-between {
        justify-content: center !important;
    }
</style>

<div class="container">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="text-center mb-4 mt-3">
        @if(isset($category))
            Sản phẩm thuộc: <span class="text-primary">{{ $category->name }}</span>
        @elseif(isset($keyword))
            Kết quả tìm kiếm cho: <span class="text-danger">"{{ $keyword }}"</span>
        @else
            Sản Phẩm Mới Nhất
        @endif
    </h2>
    
    <div class="row">
        @if(isset($products) && $products->count() > 0)
            @foreach($products as $sp)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('uploads/products/'.$sp->image) }}" class="card-img-top" alt="{{ $sp->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $sp->name }}</h5>
                        <p class="text-danger fw-bold mb-3">{{ number_format($sp->price) }} VNĐ</p>
                        
                        <div class="d-flex flex-column gap-2 mt-3">
                            <a href="{{ route('product.detail', $sp->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                Chi tiết sản phẩm
                            </a>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('cart.add', $sp->id) }}" class="btn btn-outline-success btn-sm w-50" title="Thêm vào giỏ">
                                    <i class="bi bi-cart-plus"></i> Thêm
                                </a>
                                
                                <a href="{{ route('cart.add', ['id' => $sp->id, 'buy_now' => 1]) }}" class="btn btn-success btn-sm w-50 text-white fw-bold">
                                    Mua ngay
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <p class="text-center mt-5 text-muted">Chưa có sản phẩm nào trong cửa hàng.</p>
        @endif
    </div>
    
    <div class="phan-trang-custom mt-5 mb-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
