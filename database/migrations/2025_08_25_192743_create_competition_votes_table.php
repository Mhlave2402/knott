<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('competition_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_entry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Registered users
            $table->string('guest_email')->nullable(); // Guest voters (non-registered)
            $table->string('ip_address'); // For fraud prevention
            $table->string('user_agent')->nullable(); // Browser info
            $table->integer('vote_value')->default(1); // Could be weighted voting later
            $table->text('comment')->nullable(); // Optional comment with vote
            $table->boolean('is_verified')->default(true); // For spam prevention
            $table->timestamp('voted_at')->useCurrent();
            $table->timestamps();
            
            // Prevent duplicate votes
            $table->unique(['competition_entry_id', 'user_id']);
            $table->unique(['competition_entry_id', 'guest_email']);
            $table->index(['competition_entry_id', 'is_verified']);
            $table->index(['ip_address', 'voted_at']); // For fraud detection
        });
    }

    public function down()
    {
        Schema::dropIfExists('competition_votes');
    }
};