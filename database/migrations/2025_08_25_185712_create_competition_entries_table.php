<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('competition_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('couple_id')->constrained('users')->cascadeOnDelete();
            $table->string('entry_title'); // Title for their wedding submission
            $table->date('wedding_date');
            $table->string('venue_name');
            $table->string('venue_location');
            $table->integer('guest_count');
            $table->decimal('total_budget', 12, 2)->nullable(); // Optional to share
            $table->string('wedding_theme');
            $table->text('wedding_story'); // Their love story or wedding story
            $table->text('what_made_it_special')->nullable(); // What made their day unique
            $table->json('vendor_list'); // Array of vendor IDs and names used
            $table->json('photos'); // Array of photo file paths
            $table->json('videos')->nullable(); // Array of video file paths
            $table->string('featured_photo')->nullable(); // Main photo for display
            $table->json('photo_credits')->nullable(); // Photographer/vendor credits
            $table->boolean('consent_social_media')->default(false);
            $table->boolean('consent_marketing')->default(false);
            $table->boolean('consent_vendor_promotion')->default(false);
            $table->json('hashtags')->nullable(); // Social media hashtags
            $table->enum('status', [
                'draft', 'submitted', 'under_review', 'approved', 
                'shortlisted', 'winner', 'runner_up', 'rejected'
            ])->default('draft');
            $table->integer('public_votes')->default(0);
            $table->decimal('admin_score', 4, 2)->nullable(); // Admin scoring out of 100
            $table->decimal('final_score', 4, 2)->nullable(); // Combined public + admin score
            $table->integer('final_rank')->nullable(); // Overall ranking
            $table->text('admin_notes')->nullable();
            $table->text('judge_feedback')->nullable();
            $table->json('score_breakdown')->nullable(); // Detailed scoring by criteria
            $table->boolean('is_featured')->default(false); // Featured on homepage
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['competition_id', 'status']);
            $table->index(['couple_id', 'status']);
            $table->index(['public_votes', 'final_score']);
            $table->index(['wedding_date', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('competition_entries');
    }
};