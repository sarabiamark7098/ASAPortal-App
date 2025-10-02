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
        Schema::create('janitorial_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date_requested');
            $table->string('requesting_office')->fulltext()->nullable();
            $table->string('control_number')->nullable()->unique();
            $table->text('purpose')->fulltext()->nullable();
            $table->integer('count_utility')->nullable();
            $table->date('requested_date')->nullable();
            $table->time('requested_time')->nullable();
            $table->text('location')->fulltext()->nullable();
            $table->string('fund_source')->fulltext()->nullable();
            $table->string('office_head')->fulltext()->nullable();
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
        Schema::dropIfExists('janitorial_requests');
    }
};
