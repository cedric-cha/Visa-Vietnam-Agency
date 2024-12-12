<?php

use App\Models\Order;
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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignIdFor(Order::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('full_name');
            $table->string('country');
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('email');
            $table->string('address');
            $table->string('phone_number');
            $table->string('passport_number');
            $table->date('passport_expiration_date');
            $table->string('photo');
            $table->string('passport_image');
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
