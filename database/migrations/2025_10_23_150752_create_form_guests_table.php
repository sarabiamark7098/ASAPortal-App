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
        Schema::create('form_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_request_id')->nullable()->constrained('entry_requests')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('full_name')->fulltext()->nullable();
            $table->text('purpose')->fulltext()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_guests');
    }
};
