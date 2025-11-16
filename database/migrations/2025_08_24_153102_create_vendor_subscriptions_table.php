<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendor_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_profile_id')->constrained()->cascadeOnDelete();
            $table->enum('plan', ['basic', 'premium', 'pro'])->default('basic');
            $table->decimal('amount', 8, 2);
            $table->date('starts_at');
            $table->date('expires_at');
            $table->boolean('is_active')->default(true);
            $table->string('payment_reference')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendor_subscriptions');
    }
};