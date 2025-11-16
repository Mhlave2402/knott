<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained('users')->cascadeOnDelete();
            $table->string('event_type')->default('wedding');
            $table->date('event_date');
            $table->string('venue_location');
            $table->integer('guest_count');
            $table->decimal('total_budget', 12, 2);
            $table->json('category_budgets'); // {"photography": 15000, "catering": 50000}
            $table->string('style_preference'); // classic, modern, rustic, traditional, bohemian
            $table->json('color_scheme')->nullable(); // ["gold", "ivory", "burgundy"]
            $table->text('special_requirements')->nullable();
            $table->text('inspiration_notes')->nullable();
            $table->enum('urgency', ['flexible', 'moderate', 'urgent'])->default('moderate');
            $table->enum('status', ['draft', 'submitted', 'quotes_received', 'completed', 'expired'])->default('draft');
            $table->json('matched_vendors')->nullable(); // AI match results with confidence scores
            $table->json('ai_analysis')->nullable(); // Store AI insights and recommendations
            $table->integer('total_quotes_received')->default(0);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['couple_id', 'status']);
            $table->index(['venue_location', 'event_date']);
            $table->index(['expires_at', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('quote_requests');
    }
};