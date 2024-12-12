<?php

use App\Models\EntryPort;
use App\Models\ProcessingTime;
use App\Models\Purpose;
use App\Models\TimeSlot;
use App\Models\VisaType;
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
            $table
                ->foreignIdFor(ProcessingTime::class)
                ->nullable()
                ->change();
            $table
                ->foreignIdFor(Purpose::class)
                ->nullable()
                ->change();
            $table
                ->foreignIdFor(VisaType::class)
                ->nullable()
                ->change();
            $table
                ->foreignIdFor(EntryPort::class)
                ->nullable()
                ->change();
            $table
                ->date('arrival_date')
                ->nullable()
                ->change();
            $table
                ->date('departure_date')
                ->nullable()
                ->change();
            $table->foreignIdFor(TimeSlot::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('fast_track_entry_port_id')
                ->nullable()
                ->references('id')
                ->on('entry_ports');
            $table->date('fast_track_date')->nullable();
            $table->string('service')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
