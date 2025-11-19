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
        Schema::create('air_transport_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date_requested');
            $table->string('requesting_office')->fulltext()->nullable();
            $table->string('control_number')->nullable()->unique();
            $table->string('fund_source')->nullable();
            $table->string('trip_ticket_type')->nullable()->index();
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
        Schema::dropIfExists('air_transport_requests');
    }
};
