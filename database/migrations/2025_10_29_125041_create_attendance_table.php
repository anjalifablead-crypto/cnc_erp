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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->string('mf_no');
            $table->date('date_from');
            $table->date('date_to');
            $table->integer('operator_id');
            $table->bigInteger('man_hour')->default(0.00);
            $table->bigInteger('utilised_hour')->default(0.00);
            $table->bigInteger('idle_hour')->default(0.00);
            $table->bigInteger('operator_eff')->default(0.00);
            $table->bigInteger('machine_eff')->default(0.00);
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
        Schema::dropIfExists('attendance');
    }
};
