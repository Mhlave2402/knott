<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_well_id')->constrained()->onDelete('cascade');
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('guest_fee', 10, 2);
            $table->decimal('total_paid', 10, 2);
            $table->text('message')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->enum('status', ['pending_payment', 'completed', 'failed', 'refunded'])->default('pending_payment');
            $table->string('stripe_payment_intent')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['gift_well_id', 'status']);
            $table->index('paid_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};