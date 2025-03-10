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
        Schema::create('session_classes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('price')->default(0);
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->enum('status', ['pending', 'processing', 'done', 'cancelled'])->default('pending');
            $table->enum('active', ['active', 'inactive'])->default('active');
            // $table->enum('payment_method', ['instalment', 'paid', 'unpaid'])->default('unpaid');
            // $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_classes');
    }
};
