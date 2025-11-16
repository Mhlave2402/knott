<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quote_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->decimal('quoted_price', 12, 2);
            $table->decimal('deposit_amount', 12, 2)->nullable();
            $table->text('inclusions'); // What's included in the quote
            $table->text('exclusions')->nullable(); // What's NOT included
            $table->json('package_details'); // Detailed breakdown
            $table->json('additional_services')->nullable(); // Optional add-ons with prices
            $table->integer('preparation_days')->default(1); // Days needed for preparation
            $table->integer('service_duration_hours')->default(8); // How long the service lasts
            $table->text('terms_conditions')->nullable();
            $table->text('vendor_notes')->nullable(); // Personal message from vendor
            $table->json('availability_dates')->nullable(); // Available dates if event date flexible
            $table->decimal('discount_percentage', 5, 2)->default(0); // If any discount applied
            $table->enum('status', ['pending', 'sent', 'viewed', 'accepted', 'declined', 'expired'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
            
            // Indexes
            $table->index(['quote_request_id', 'status']);
            $table->index(['vendor_id', 'status']);
            $table->index(['expires_at', 'status']);
            $table->unique(['quote_request_id', 'vendor_id', 'service_id']); // Prevent duplicate quotes
        });
    }

    public function down()
    {
        Schema::dropIfExists('quote_responses');
    }
};