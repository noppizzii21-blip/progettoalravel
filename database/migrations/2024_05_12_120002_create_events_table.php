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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // organizer
            $table->foreignId('venue_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('city');
            $table->string('zone');
            $table->string('address');
            $table->dateTime('date');
            $table->time('time');
            $table->integer('min_age')->nullable();
            $table->integer('max_participants')->nullable();
            $table->enum('access_type', ['free', 'presale', 'waiting_list', 'open'])->default('free');
            $table->decimal('presale_price', 8, 2)->nullable();
            $table->integer('presale_quantity')->nullable();
            $table->enum('status', ['pending', 'venue_approved', 'moderator_approved', 'published', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};