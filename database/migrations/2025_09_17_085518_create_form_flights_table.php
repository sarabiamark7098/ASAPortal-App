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
        Schema::create('form_flights', function (Blueprint $table) {
            $table->id();
            $table->morphs('flight');
            $table->string('destination_from')->nullable();
            $table->string('destination_to')->nullable();
            $table->boolean('trip_mode')->nullable();
            $table->date('date')->nullable();
            $table->time('etd')->nullable();
            $table->time('eta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_flights');
    }
};
