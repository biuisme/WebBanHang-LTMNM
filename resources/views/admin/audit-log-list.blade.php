@extends('admin.index')

@section('title', 'Lịch sử hoạt động')

@section('content')
<div class="bg-white rounded-4 p-4" style="box-shadow:0 8px 24px rgba(0,0,0,.06);">

    <h4 class="mb-4 fw-bold">Lịch sử hoạt động</h4>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr class="text-muted">
                    <th>Thời gian</th>
                    <th>Người thực hiện</th>
                    <th>Hành động</th>
                    <th>Đối tượng</th>
                    <th>Mô tả</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ $log->actor_name ?? 'Hệ thống' }}
                        @if($log->actor_email)
                            <div class="text-muted small">{{ $log->actor_email }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $log->action_color }}">
                            {{ $log->action_name }}
                        </span>
                    </td>
                    <td>{{ $log->subject_name ?? '—' }}</td>
                    <td>{{ $log->description }}</td>
                    <td class="text-muted small">{{ $log->ip_address }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Chưa có hoạt động nào được ghi nhận</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $logs->links() }}
    </div>

</div>
@endsection