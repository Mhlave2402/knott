<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('negotiation_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('negotiator_id')->constrained()->cascadeOnDelete();
            $table->datetime('scheduled_date');
            $table->integer('duration_hours')->default(2);
            $table->enum('meeting_type', ['in_person', 'video_call', 'phone_call'])->default('in_person');
            $table->string('meeting_location')->nullable(); // Address for in-person meetings
            $table->string('video_call_link')->nullable(); // Zoom/Teams link
            $table->json('family_details'); // Names, relationships of people involved
            $table->text('cultural_background'); // Cultural context
            $table->text('negotiation_goals'); // What they want to achieve
            $table->text('special_requirements')->nullable();
            $table->json('preferred_languages'); // Languages to be used in negotiation
            $table->decimal('consultation_cost', 8, 2);
            $table->decimal('total_cost', 8, 2); // If ongoing service
            $table->enum('payment_status', ['pending', 'paid', 'refunded', 'cancelled'])->default('pending');
            $table->string('payment_reference')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show'])->default('pending');
            $table->text('preparation_notes')->nullable(); // Negotiator's preparation notes
            $table->text('session_summary')->nullable(); // Summary after completion
            $table->json('outcomes')->nullable(); // Results and agreements reached
            $table->boolean('follow_up_required')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->integer('rating')->nullable(); // 1-5 stars
            $table->text('review')->nullable();
            $table->text('couple_feedback')->nullable();
            $table->text('negotiator_feedback')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['couple_id', 'status']);
            $table->index(['negotiator_id', 'scheduled_date']);
            $table->index(['scheduled_date', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('negotiation_bookings');
    }
};