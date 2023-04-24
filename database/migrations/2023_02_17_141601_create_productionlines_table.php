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
        Schema::create('productionlines', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("name",255)->nullable();
            $table->decimal("capacity")->nullable();
            $table->boolean('status')->default("1");
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
        Schema::dropIfExists('productionlines');
        Schema::enableForeignKeyConstraints();
    }
};
