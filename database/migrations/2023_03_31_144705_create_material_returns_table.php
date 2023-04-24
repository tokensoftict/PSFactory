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
        Schema::create('material_returns', function (Blueprint $table) {
            $table->id();
            $table->date('return_date')->nullable();
            $table->time('return_time')->nullable();
            $table->unsignedBigInteger('return_by_id')->nullable();
            $table->nullableMorphs("return");
            $table->foreignId("status_id")->nullable()->constrained()->nullOnDelete();
            $table->foreign('return_by_id')->on('users')->references('id')->nullOnDelete();
            $table->text("description")->nullable();
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
        Schema::dropIfExists('material_returns');
        Schema::enableForeignKeyConstraints();
    }
};
