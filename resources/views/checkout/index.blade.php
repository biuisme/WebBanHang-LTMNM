@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">💳 Thanh toán đơn hàng</h2>

    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin giao hàng</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ tên</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="shipping_address" required placeholder="Nhập địa chỉ nhận hàng chi tiết">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" required placeholder="Nhập số điện thoại liên hệ">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ghi chú (Tùy chọn)</label>
                            <textarea class="form-control" name="note" rows="3" placeholder="Ghi chú thêm cho người giao hàng..."></textarea>
                        </div>

                        <h5 class="mt-4 mb-3 fw-bold border-bottom pb-2">Phương thức thanh toán</h5>
                        
                        <div class="form-check mb-3 p-3 border rounded shadow-sm">
                            <input class="form-check-input ms-1" type="radio" name="payment_method" id="method_cod" value="cod" {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                            <label class="form-check-label ms-2 w-100 cursor-pointer" for="method_cod">
                                <i class="bi bi-cash-stack text-success fs-4 me-2 align-middle"></i>
                                <span class="fw-bold align-middle">Thanh toán khi nhận hàng (COD)</span>
                            </label>
                        </div>

                        <div class="form-check mb-3 p-3 border rounded shadow-sm">
                            <input class="form-check-input ms-1" type="radio" name="payment_method" id="method_bank" value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                            <label class="form-check-label ms-2 w-100 cursor-pointer" for="method_bank">
                                <i class="bi bi-qr-code-scan text-primary fs-4 me-2 align-middle"></i>
                                <span class="fw-bold align-middle">Thanh toán qua App Ngân hàng (VietQR)</span>
                            </label>
                        </div>

                        <div class="form-check mb-3 p-3 border rounded shadow-sm">
                            <input class="form-check-input ms-1" type="radio" name="payment_method" id="method_card" value="card" {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                            <label class="form-check-label ms-2 w-100 cursor-pointer" for="method_card">
                                <i class="bi bi-credit-card-2-front text-warning fs-4 me-2 align-middle"></i>
                                <span class="fw-bold align-middle">Thanh toán bằng Thẻ (Nội địa/Quốc tế)</span>
                            </label>
                            
                            <!-- Form thanh toán thẻ -->
                            <div class="mt-3 {{ old('payment_method') == 'card' || $errors->has('card_number') || $errors->has('expiry_date') || $errors->has('cvv') ? '' : 'd-none' }}" id="card_details">
                                <hr>
                                <div class="mb-2">
                                    <label class="form-label">Số thẻ <span class="text-danger">*</span></label>
                                    <input type="text" name="card_number" class="form-control @error('card_number') is-invalid @enderror" value="{{ old('card_number') }}" placeholder="Ví dụ: 1234567812345678" pattern="[0-9]{16}" title="Vui lòng nhập đúng 16 số">
                                    @error('card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <label class="form-label">Ngày hết hạn <span class="text-danger">*</span></label>
                                        <input type="text" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}" placeholder="MM/YY" pattern="(0[1-9]|1[0-2])\/([0-9]{2})" title="Vui lòng nhập định dạng MM/YY">
                                        @error('expiry_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label class="form-label">CVV <span class="text-danger">*</span></label>
                                        <input type="text" name="cvv" class="form-control @error('cvv') is-invalid @enderror" value="{{ old('cvv') }}" placeholder="123" pattern="[0-9]{3}" title="Vui lòng nhập đúng 3 số">
                                        @error('cvv')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <small class="text-muted">Hệ thống sẽ kiểm tra đúng định dạng số thẻ (16 số), ngày (MM/YY) và CVV (3 số).</small>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success btn-lg w-100 shadow">
                                Đặt Hàng Ngay
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($cart as $details)
                            <li class="list-group-item d-flex justify-content-between lh-sm px-0">
                                <div>
                                    <h6 class="my-0">{{ $details['name'] }}</h6>
                                    <small class="text-muted">Số lượng: {{ $details['quantity'] }}</small>
                                </div>
                                <span class="text-muted">{{ number_format($details['price'] * $details['quantity']) }} đ</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-between border-top pt-3">
                        <strong class="fs-5">Tổng cộng</strong>
                        <strong class="text-danger fs-5">{{ number_format($total) }} đ</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="payment_method"]');
        const cardDetails = document.getElementById('card_details');

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'card') {
                    cardDetails.classList.remove('d-none');
                } else {
                    cardDetails.classList.add('d-none');
                }
            });
        });
    });
</script>

<style>
    .cursor-pointer { cursor: pointer; }
    .form-check-input:checked { background-color: #198754; border-color: #198754; }
    .form-check { transition: all 0.2s ease-in-out; }
    .form-check:hover { background-color: #f8f9fa; }
</style>
@endsection
