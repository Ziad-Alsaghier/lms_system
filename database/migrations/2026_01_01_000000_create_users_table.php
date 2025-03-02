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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('age')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string( 'password')->nullable();
            $table->enum( 'role',['admin','teacher','student'])->default('teacher'); // this field for role
            $table->string('parent_phone')->nullable();
            $table->string('category')->nullable(); // this field for category   
            $table->enum('payment_method',['instalment','paid','unpaid'])->nullable(); // this field for payment method
            $table->enum('status',['active','inactive'])->default('active'); // this field for status
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->string('sessionCount')->default(0); // this field for session count
            $table->string('subsciption')->nullable(); // this field for subscription
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
