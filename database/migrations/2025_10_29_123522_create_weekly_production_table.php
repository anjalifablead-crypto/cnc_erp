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
        Schema::create('weekly_production', function (Blueprint $table) {
            $table->id();
            $table->Integer('operator_id');
            $table->string('week');
            $table->Integer('machine_id');
            $table->Integer('process_id');
            $table->integer('qty');
            $table->integer('mnts_taken');
            $table->integer('cnc_a')->nullable();
            $table->integer('cnc_b')->nullable();
            $table->integer('cnc_c')->nullable();
            $table->integer('cnc_d')->nullable();
            $table->integer('cnc_e')->nullable();
            $table->integer('cnc_f')->nullable();
            $table->integer('cnc_g')->nullable();
            $table->integer('cnc_h')->nullable();
            $table->integer('cnc_i')->nullable();
            $table->integer('cnc_k')->nullable();
            $table->integer('idle_time')->nullable();
            $table->integer('total')->nullable();
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
        Schema::dropIfExists('weekly_production');
    }
};
