<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('terms_and_conditions');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('voting_end_date')->nullable(); // If public voting is enabled
            $table->date('winner_announcement_date');
            $table->json('rules'); // Detailed competition rules
            $table->json('eligibility_criteria'); // Who can enter
            $table->json('prizes'); // Prize structure for 1st, 2nd, 3rd place
            $table->json('categories')->nullable(); // Different competition categories
            $table->integer('min_vendors_required')->default(4); // Minimum vendors to qualify
            $table->integer('max_photos')->default(20);
            $table->integer('max_videos')->default(5);
            $table->boolean('public_voting_enabled')->default(true);
            $table->integer('public_voting_weight')->default(30); // Percentage of total score
            $table->integer('admin_judging_weight')->default(70); // Percentage of total score
            $table->json('judging_criteria'); // What judges look for
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('total_entries')->default(0);
            $table->integer('total_votes')->default(0);
            $table->string('banner_image')->nullable();
            $table->string('winner_badge_image')->nullable();
            $table->json('sponsor_details')->nullable(); // Competition sponsors
            $table->timestamps();
            
            // Indexes
            $table->index(['is_active', 'start_date', 'end_date']);
            $table->index(['slug']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('competitions');
    }
};
