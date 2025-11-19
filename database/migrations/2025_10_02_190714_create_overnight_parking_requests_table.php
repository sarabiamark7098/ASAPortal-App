<?php

use App\Enums\Status;
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
        Schema::create('overnight_parking_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date_requested');
            $table->string('control_number')->nullable()->unique();
            $table->text('justification')->fulltext()->nullable();
            $table->date('requested_start')->nullable();
            $table->date('requested_end')->nullable();
            $table->time('requested_time')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('model')->nullable();
            $table->string('office')->fulltext()->nullable();
            $table->string('requester_name')->fulltext()->nullable();
            $table->string('requester_position')->nullable();
            $table->string('requester_contact_number')->nullable();
            $table->string('requester_email')->nullable();
            $table->enum('status', Status::values())->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overnight_parking_requests');
    }
};
