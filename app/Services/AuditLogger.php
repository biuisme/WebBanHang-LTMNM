<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public static function record(
        string $action,
        ?Model $subject = null,
        array $oldValues = [],
        array $newValues = [],
        ?string $description = null
    ): AuditLog {
        $actor = Auth::user();
        $request = request();

        return AuditLog::create([
            'actor_id' => $actor?->id,
            'actor_name' => $actor?->name,
            'actor_email' => $actor?->email,
            'actor_role' => $actor?->role,

            'action' => $action,

            'subject_type' => $subject
                ? $subject::class
                : null,

            'subject_id' => $subject?->getKey(),

            'subject_name' => $subject?->getAttribute('name'),
            'subject_email' => $subject?->getAttribute('email'),
            'subject_role' => $subject?->getAttribute('role'),

            'description' => $description,

            'old_values' => empty($oldValues)
                ? null
                : self::sanitize($oldValues),

            'new_values' => empty($newValues)
                ? null
                : self::sanitize($newValues),

            'ip_address' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    private static function sanitize(array $values): array
    {
        return collect($values)
            ->except([
                'password',
                'password_confirmation',
                'remember_token',
            ])
            ->toArray();
    }
}