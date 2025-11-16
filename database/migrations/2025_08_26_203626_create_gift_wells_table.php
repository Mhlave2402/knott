<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gift_wells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained('couple_profiles')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('target_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('withdrawal_fee', 10, 2)->nullable();
            $table->enum('status', ['active', 'withdrawn', 'suspended'])->default('active');
            $table->date('wedding_date');
            $table->boolean('is_public')->default(true);
            $table->text('thank_you_message')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'is_public']);
            $table->index('wedding_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gift_wells');
    }
};
