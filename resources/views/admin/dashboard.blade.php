@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
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
                <h2 class="fw-bold">45</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card shadow border-0" style="border-left: 5px solid #ffab00 !important;">
            <div class="card-body">
                <h5 class="text-muted">Doanh thu</h5>
                <h2 class="fw-bold">18.500.000đ</h2>
            </div>
        </div>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body">
        <h5 class="mb-3 fw-bold">Doanh thu theo tháng</h5>
        <canvas id="revenueChart" height="100"></canvas>
        <p class="text-muted small mt-3 mb-0">
            * Dữ liệu mẫu, sẽ cập nhật khi có hệ thống đơn hàng thực tế.
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('revenueChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                     'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: [12000000, 15500000, 9800000, 17200000, 14000000, 18500000,
                       21000000, 19500000, 16800000, 23000000, 20500000, 25000000],
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
                        label: function(context) {
                            return context.parsed.y.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return (value / 1000000) + 'tr';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection