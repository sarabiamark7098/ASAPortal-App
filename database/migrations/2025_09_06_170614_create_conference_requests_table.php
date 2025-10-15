<?php

use App\Enums\ConferenceRoom;
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
        Schema::create('conference_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date_requested');
            $table->string('requesting_office')->fulltext()->nullable();
            $table->string('control_number')->nullable()->unique();
            $table->text('purpose')->fulltext()->nullable();
            $table->date('requested_start');
            $table->time('requested_time_start');
            $table->date('requested_end');
            $table->time('requested_time_end');
            $table->integer('number_of_persons')->nullable();
            $table->string('focal')->nullable();
            $table->enum('conference_room', ConferenceRoom::values())->nullable();
            $table->string('requester_name')->fulltext()->nullable();
            $table->string('requester_position')->nullable();
            $table->string('requester_contact_number')->nullable();
            $table->string('requester_email')->nullable();
            $table->boolean('is_conference_available')->nullable();
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
        Schema::dropIfExists('conference_requests');
    }
};
