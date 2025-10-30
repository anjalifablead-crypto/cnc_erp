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
        Schema::create('process_cycle', function (Blueprint $table) {
            $table->id();
            $table->Integer('process_id');
            $table->integer('cycle_secs');
            $table->integer('cycle_mins');
            $table->integer('created_by');
            $table->integer('is_deleted')->default(0);
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_cycle');
    }
};
