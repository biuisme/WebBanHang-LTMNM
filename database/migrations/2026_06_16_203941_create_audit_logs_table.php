<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('actor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('actor_name')->nullable();
            $table->string('actor_email')->nullable();
            $table->string('actor_role', 30)->nullable();

            $table->string('action', 50);

            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();

            $table->string('subject_name')->nullable();
            $table->string('subject_email')->nullable();
            $table->string('subject_role', 30)->nullable();

            $table->text('description')->nullable();

            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            $table->ipAddress('ip_address')->nullable();
            $table->string('method', 10)->nullable();
            $table->text('url')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            $table->index([
                'action',
                'created_at',
            ]);

            $table->index([
                'subject_type',
                'subject_id',
            ]);

            $table->index('subject_role');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
