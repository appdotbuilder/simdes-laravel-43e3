<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'resident', 'village_head'])->default('resident');
            $table->foreignId('resident_id')->nullable()->constrained()->nullOnDelete();
            $table->string('phone')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending_verification'])->default('pending_verification');
            $table->timestamp('verified_at')->nullable();
            
            $table->index(['role', 'status']);
            $table->index('resident_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['resident_id']);
            $table->dropIndex(['role', 'status']);
            $table->dropIndex(['resident_id']);
            $table->dropColumn(['role', 'resident_id', 'phone', 'status', 'verified_at']);
        });
    }
};