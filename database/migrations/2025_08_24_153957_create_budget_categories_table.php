<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('budget_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_profile_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Venue, Photography, Catering, etc.
            $table->decimal('allocated_amount', 10, 2)->default(0);
            $table->decimal('spent_amount', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->boolean('is_required')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('budget_categories');
    }
};