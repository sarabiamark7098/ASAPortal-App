<?php

use App\Enums\VehicleUnitType;
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
        Schema::create('vehicles', function (Blueprint $table){
            $table->id();
            $table->string('plate_number');
            $table->enum('unit_type', VehicleUnitType::values());
            $table->string('brand');
            $table->string('model');
            $table->integer('purchase_year');
            $table->integer('model_year');
            $table->string('engine_number');
            $table->string('chasis_number');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
