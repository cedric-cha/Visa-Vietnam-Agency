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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('time_slot_departure_id')
                ->nullable()
                ->references('id')
                ->on('time_slots');
            $table->foreignId('fast_track_exit_port_id')
                ->nullable()
                ->references('id')
                ->on('entry_ports');
            $table->date('fast_track_departure_date')->nullable();
            $table->string('fast_track_departure_time')->nullable();
            $table->string('fast_track_flight_number_departure')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn([
                'time_slot_departure_id',
                'fast_track_exit_port_id',
                'fast_track_departure_date',
                'fast_track_departure_time',
                'fast_track_flight_number_departure',
            ]);
        });
    }
};
