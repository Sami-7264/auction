<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id')->default(0);
            $table->text('title');
            $table->string('path', 255);
            $table->text('image');
            $table->decimal('price', 18, 4)->default(0.00);
            $table->tinyInteger('schedule')->comment('1 => Yes, 0 => No');
            $table->unsignedBigInteger('bid_count')->default(0);
            $table->decimal('avg_review', 3,2)->default(0);
            $table->unsignedBigInteger('review_count')->default(0);
            $table->dateTime('started_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->text('short_description');
            $table->longText('description');
            $table->longText('specification');
            $table->tinyInteger('status')->default(0)->comment('0 => pending, 1 => Live, 2 => upcomming, 3 => expired, 4 => cancel, 5 => delivered');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
