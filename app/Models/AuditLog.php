<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'actor_id',
        'actor_name',
        'actor_email',
        'actor_role',
        'action',
        'subject_type',
        'subject_id',
        'subject_name',
        'subject_email',
        'subject_role',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'method',
        'url',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
        ];
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /*public function getActionNameAttribute(): string
    {
        return match ($this->action) {
            'created' => 'Thêm tài khoản',
            'registered' => 'Đăng ký tài khoản',
            'viewed' => 'Xem chi tiết tài khoản',
            'viewed_list' => 'Xem danh sách tài khoản',
            'updated' => 'Cập nhật tài khoản',
            'deleted' => 'Xóa tài khoản',
            default => $this->action,
        };
    }*/
	
    public function getActionNameAttribute(): string
    {
         $subject = match ($this->subject_type) {
           'Product' => 'sản phẩm',
           'User' => 'tài khoản',
           'Category' => 'danh mục',
           default => 'dữ liệu',
         };

         return match ($this->action) {
           'created' => 'Thêm ' . $subject,
           'registered' => 'Đăng ký ' . $subject,
           'viewed' => 'Xem chi tiết ' . $subject,
           'viewed_list' => 'Xem danh sách ' . $subject,
           'updated' => 'Cập nhật ' . $subject,
           'deleted' => 'Xóa ' . $subject,
           default => $this->action,
         };
    }

    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            'created', 'registered' => 'success',
            'viewed', 'viewed_list' => 'info',
            'updated' => 'warning',
            'deleted' => 'danger',
            default => 'secondary',
        };
    }
}