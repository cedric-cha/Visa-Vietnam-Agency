<?php

use App\Enums\OrderStatus;
use App\Models\EntryPort;
use App\Models\ProcessingTime;
use App\Models\Purpose;
use App\Models\VisaType;
use App\Models\Voucher;
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
        Schema::disableForeignKeyConstraints();

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignIdFor(ProcessingTime::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(Purpose::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(VisaType::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(EntryPort::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(Voucher::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->float('total_fees')->nullable();
            $table->float('total_fees_with_discount')->nullable();
            $table->string('reference')->nullable();
            $table->date('arrival_date');
            $table->date('departure_date');
            $table->string('status')->default(OrderStatus::PENDING->value);
            $table->string('visa_pdf')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('orders');
        Schema::enableForeignKeyConstraints();
    }
};
