@extends('layouts.admin')
@section('title', 'Quản lý đơn hàng')
@section('content')

<div class="card shadow border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Quản lý đơn hàng</h5>

            {{-- Lọc trạng thái --}}
            <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex gap-2">
                <select name="status" class="form-select form-select-sm" style="width:180px" onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    @foreach(['pending'=>'Chờ xác nhận','confirmed'=>'Đã xác nhận','shipping'=>'Đang giao','completed'=>'Hoàn thành','cancelled'=>'Đã hủy'] as $val=>$label)
                        <option value="{{ $val }}" {{ request('status')==$val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Khách hàng</th>
                        <th>Địa chỉ</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td class="text-muted small">{{ $order->shipping_address }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                        <td>
                            @php
                                $badge = match($order->status) {
                                    'completed' => 'success',
                                    'pending'   => 'warning',
                                    'shipping'  => 'info',
                                    'confirmed' => 'primary',
                                    'cancelled' => 'danger',
                                    default     => 'secondary',
                                };
                                $label = match($order->status) {
                                    'pending'   => 'Chờ xác nhận',
                                    'confirmed' => 'Đã xác nhận',
                                    'shipping'  => 'Đang giao',
                                    'completed' => 'Hoàn thành',
                                    'cancelled' => 'Đã hủy',
                                    default     => $order->status,
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                        <td>
                            @if(in_array($order->status, ['completed', 'cancelled']))
                                <span class="text-muted small">—</span>
                            @else
                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    @php
                                        $flow = ['pending'=>0,'confirmed'=>1,'shipping'=>2,'completed'=>3];
                                        $cur  = $order->status;
                                        $options = [
                                            'pending'   => 'Chờ xác nhận',
                                            'confirmed' => 'Đã xác nhận',
                                            'shipping'  => 'Đang giao',
                                            'completed' => 'Hoàn thành',
                                            'cancelled' => 'Hủy đơn',
                                        ];
                                    @endphp
                                    <select name="status" class="form-select form-select-sm" style="width:160px">
                                        @foreach($options as $val => $lbl)
                                            @php
                                                $isCurrentOrPast = ($val !== 'cancelled') && isset($flow[$val]) && $flow[$val] < $flow[$cur];
                                                $isCancelDisabled = ($val === 'cancelled') && !in_array($cur, ['pending','confirmed']);
                                            @endphp
                                            <option value="{{ $val }}"
                                                {{ $cur === $val ? 'selected' : '' }}
                                                {{ ($isCurrentOrPast || $isCancelDisabled) ? 'disabled' : '' }}>
                                                {{ $lbl }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-primary">Lưu</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">Không có đơn hàng nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Phân trang --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>

@endsection