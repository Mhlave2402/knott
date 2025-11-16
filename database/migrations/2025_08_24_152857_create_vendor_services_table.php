<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendor_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_profile_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // "Photography Package", "DJ Services"
            $table->text('description');
            $table->enum('category', [
                'photography', 'videography', 'catering', 'venue', 'decoration',
                'music', 'flowers', 'cake', 'transport', 'makeup', 'hair', 'other'
            ]);
            $table->decimal('price', 10, 2);
            $table->string('price_type')->default('fixed'); // fixed, hourly, per_person
            $table->json('inclusions')->nullable(); // What's included
            $table->json('exclusions')->nullable(); // What's not included
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_services');
    }
};