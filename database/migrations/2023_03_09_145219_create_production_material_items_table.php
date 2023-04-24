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
        Schema::create('production_material_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("production_id")->constrained()->cascadeOnDelete();
            $table->foreignId('rawmaterial_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('production_template_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('status_id')->constrained()->cascadeOnDelete();
            $table->boolean('extra')->default(0);
            $table->string('name')->nullable();
            $table->decimal("measurement",20,5);
            $table->string("unit")->nullable();
            $table->decimal("convert_measurement",20,5);
            $table->string("convert_unit")->nullable();
            $table->decimal('returns',20,5)->default(0);
            $table->date("production_date");
            $table->time("production_time")->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->time('approved_time')->nullable();
            $table->foreign('approved_by')->on('users')->references('id')->nullOnDelete();
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
        Schema::dropIfExists('production_material_items');
        Schema::enableForeignKeyConstraints();
    }
};
