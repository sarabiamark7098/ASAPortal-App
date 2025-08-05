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
        Schema::create('form_signatories', function (Blueprint $table) {
            $table->id();
            $table->morphs('signable');
            $table->string('label')->nullable();
            $table->string('full_name')->fulltext()->nullable();
            $table->string('position')->fulltext()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_signatories');
    }
};
