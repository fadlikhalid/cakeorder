<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('buyer_name');
            $table->string('phone');
            $table->foreignId('cake_id')->constrained('cakes');
            $table->foreignId('size_id')->constrained('cake_sizes');
            $table->date('delivery_date');
            $table->time('delivery_time');
            $table->string('message')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['pending', 'paid', 'delivering', 'delivered'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};