<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ai_matching_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_request_id')->constrained()->cascadeOnDelete();
            $table->text('ai_prompt'); // The prompt sent to AI
            $table->json('ai_response'); // Raw AI response
            $table->json('processed_matches'); // Processed and formatted matches
            $table->integer('total_matches_found');
            $table->decimal('processing_time', 8, 3); // Time taken in seconds
            $table->string('ai_model_version')->default('gemini-pro');
            $table->boolean('was_successful')->default(true);
            $table->text('error_message')->nullable();
            $table->json('fallback_matches')->nullable(); // Manual matches if AI fails
            $table->timestamps();
            
            $table->index(['quote_request_id']);
            $table->index(['was_successful', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_matching_logs');
    }
};

?>