@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

{{-- STAT CARDS --}}
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow border-0" style="border-left: 5px solid #696cff !important;">
            <div class="card-body">
                <h5 class="text-muted">Tổng sản phẩm</h5>
                <h2 class="fw-bold">{{ $tongSanPham }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow border-0" style="border-left: 5px solid #03c3ec !important;">
            <div class="card-body">
                <h5 class="text-muted">Đơn hàng</h5>
                <h2 class="fw-bold">{{ $tongDonHang }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow border-0" style="border-left: 5px solid #ffab00 !important;">
            <div class="card-body">
                <h5 class="text-muted">Doanh thu</h5>
                <h2 class="fw-bold">{{ number_format($doanhThu, 0, ',', '.') }}đ</h2>
            </div>
        </div>
    </div>
</div>

{{-- PHẦN DƯỚI: BẢNG + BIỂU ĐỒ --}}
<div class="row">
    {{-- Bên trái: 10 đơn hàng gần nhất --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">10 Đơn hàng gần nhất</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donHangGanNhat as $don)
                            <tr>
                                <td>{{ $don->id }}</td>
                                <td>{{ $don->user->name ?? 'N/A' }}</td>
                                <td>{{ number_format($don->total_amount, 0, ',', '.') }}đ</td>
                                <td>
                                    @php
                                        $badge = match($don->status) {
                                            'completed'  => 'success',
                                            'pending'    => 'warning',
                                            'shipping'   => 'info',
                                            'confirmed'  => 'primary',
                                            'cancelled'  => 'danger',
                                            default      => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">{{ $don->status }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($don->created_at)->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Bên phải: Biểu đồ doanh thu --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Doanh thu theo tháng ({{ now()->year }})</h5>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const revenueData = @json($revenueData);

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: revenueData,
                borderColor: '#696cff',
                backgroundColor: 'rgba(105,108,255,0.1)',
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#696cff',
                pointRadius: 4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.parsed.y.toLocaleString('vi-VN') + 'đ'
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: val => (val / 1000000) + 'tr'
                    }
                }
            }
        }
    });
</script>
@endsection