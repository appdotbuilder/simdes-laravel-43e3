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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('name');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('gender', ['male', 'female']);
            $table->string('religion');
            $table->string('education')->nullable();
            $table->string('occupation')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->enum('family_relation', ['head', 'spouse', 'child', 'parent', 'sibling', 'other']);
            $table->string('phone')->nullable();
            $table->enum('status', ['active', 'inactive', 'moved', 'deceased'])->default('active');
            $table->timestamps();
            
            $table->index(['family_id', 'status']);
            $table->index('nik');
            $table->index(['status', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};