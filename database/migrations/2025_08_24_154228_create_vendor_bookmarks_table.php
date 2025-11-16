<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendor_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_profile_id')->constrained()->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['couple_profile_id', 'vendor_profile_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_bookmarks');
    }
};