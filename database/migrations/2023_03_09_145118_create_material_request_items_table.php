<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_request_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->nullableMorphs('requesttype');
            $table->foreignId('material_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rawmaterial_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('status_id')->constrained()->cascadeOnDelete();
            $table->decimal("measurement",20,5);
            $table->string("unit")->nullable();
            $table->decimal("convert_measurement",20,5);
            $table->string("convert_unit")->nullable();
            $table->unsignedBigInteger('resolve_by_id')->nullable();
            $table->date('resolve_date')->nullable();
            $table->time('resolve_time')->nullable();
            $table->foreign('resolve_by_id')->on('users')->references('id')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('material_request_items');
        Schema::enableForeignKeyConstraints();
    }
};
