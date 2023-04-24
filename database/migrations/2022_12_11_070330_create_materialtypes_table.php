<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materialtypes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("name");
            $table->string("storage_measurement_unit")->nullable();
            $table->string("production_measurement_unit")->nullable();
            $table->boolean('status')->default(1)->index()->comment('0=disabled, 1=enabled');
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
        Schema::dropIfExists('materialtypes');
        Schema::enableForeignKeyConstraints();
    }
};
