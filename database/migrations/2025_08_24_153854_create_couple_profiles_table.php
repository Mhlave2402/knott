<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('couple_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('partner_name')->nullable();
            $table->string('partner_email')->nullable();
            $table->date('wedding_date')->nullable();
            $table->string('venue_location')->nullable();
            $table->integer('guest_count')->nullable();
            $table->decimal('total_budget', 12, 2)->nullable();
            $table->string('wedding_style')->nullable(); // traditional, modern, rustic, etc.
            $table->json('preferences')->nullable(); // Colors, themes, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('couple_profiles');
    }
};