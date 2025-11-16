<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wedding_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_profile_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('category', ['family', 'friends', 'colleagues', 'other'])->default('friends');
            $table->enum('rsvp_status', ['pending', 'attending', 'declined', 'maybe'])->default('pending');
            $table->integer('plus_one')->default(0); // Number of additional guests
            $table->text('dietary_requirements')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('rsvp_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_guests');
    }
};