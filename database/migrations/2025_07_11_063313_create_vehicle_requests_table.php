<?php

use App\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date_requested');
            $table->string('requesting_office')->fulltext()->nullable();
            $table->string('control_number')->nullable()->unique();
            $table->text('purpose')->fulltext()->nullable();
            $table->text('passengers')->fulltext()->nullable();
            $table->date('requested_start');
            $table->time('requested_time');
            $table->date('requested_end');
            $table->string('destination')->fulltext()->nullable();
            $table->string('requester_name')->fulltext()->nullable();
            $table->string('requester_position')->nullable();
            $table->string('requester_contact_number')->nullable();
            $table->string('requester_email')->nullable();
            $table->boolean('is_vehicle_available')->nullable();
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
        Schema::dropIfExists('vehicle_requests');
    }
};
