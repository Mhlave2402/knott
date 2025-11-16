<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('business_name');
            $table->text('description');
            $table->string('location');
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->json('service_areas')->nullable(); // Array of locations they serve
            $table->decimal('starting_price', 10, 2)->nullable();
            $table->json('social_media')->nullable(); // Instagram, Facebook, etc.
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_profiles');
    }
};