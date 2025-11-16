<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Photography, Catering, Venue
            $table->text('description')->nullable(); // optional details about the service
            $table->decimal('base_price', 10, 2)->nullable(); // optional starting price
            $table->boolean('active')->default(true); // allow deactivation of service
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};
