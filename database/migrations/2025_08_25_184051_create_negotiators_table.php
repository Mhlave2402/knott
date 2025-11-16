<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('negotiators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('title')->nullable(); // Traditional title if any
            $table->text('bio');
            $table->string('profile_photo')->nullable();
            $table->json('languages_spoken'); // ["English", "Zulu", "Xhosa", "Afrikaans"]
            $table->json('cultural_expertise'); // ["Zulu", "Xhosa", "Sotho", "Tswana", "Pedi"]
            $table->json('regions_served'); // ["Gauteng", "KwaZulu-Natal", "Western Cape"]
            $table->integer('years_experience');
            $table->decimal('consultation_fee', 8, 2); // Initial consultation fee
            $table->decimal('hourly_rate', 8, 2); // Ongoing hourly rate
            $table->decimal('full_service_rate', 8, 2)->nullable(); // Complete negotiation service
            $table->json('availability_hours'); // {"monday": "09:00-17:00", "tuesday": "09:00-15:00"}
            $table->json('availability_days'); // Days of week available
            $table->string('primary_location');
            $table->boolean('travel_available')->default(false);
            $table->integer('max_travel_distance')->nullable(); // KM willing to travel
            $table->decimal('travel_fee', 8, 2)->nullable(); // Per KM or flat rate
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->integer('total_negotiations')->default(0);
            $table->integer('successful_negotiations')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->date('verified_at')->nullable();
            $table->text('cultural_notes')->nullable(); // Special cultural insights
            $table->text('approach_philosophy')->nullable(); // Their negotiation approach
            $table->json('testimonials')->nullable(); // Featured testimonials
            $table->boolean('accepts_video_calls')->default(true);
            $table->boolean('accepts_phone_calls')->default(true);
            $table->boolean('weekend_availability')->default(false);
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();
            
            // Indexes
            $table->index(['is_verified', 'status', 'rating']);
            $table->index(['primary_location', 'travel_available']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('negotiators');
    }
};