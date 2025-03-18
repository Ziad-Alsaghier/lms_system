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
        Schema::table('session_classes', function (Blueprint $table) {
            // Add Index For Date Cause When Search any Sessione Ended
            $table->index(['date', 'start']); // Adding index to date and start columns

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_classes', function (Blueprint $table) {
            // 
                $table->dropIndex(['date', 'start']); // Remove index if migration is rolled back

        });
    }
    
};
