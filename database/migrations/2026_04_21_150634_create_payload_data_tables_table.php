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
        Schema::create('payload_data_table', function (Blueprint $table) {
            $table->id();
            $table->string('scan_id')->unique();
            $table->string('session_id');
            $table->string('operator_id');
            $table->string('device_id');
            $table->string('action');
            $table->decimal('gps_lat',10,7)->nullable();
            $table->decimal('gps_lng',10,7)->nullable();
            $table->decimal('gps_accuracy',10,7)->nullable();
            $table->datetime('device_timestamp')->nullable();
            $table->string('app_version');
            $table->timestamps();
            
            //Fast filtering of data based on timestamps.
            $table->index('device_timestamp');
            //Use a composite index to apply filters on GPS data for faster searching.
            $table->index(['gps_lat','gps_lng','gps_accuracy']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payload_data_table');
    }
};
