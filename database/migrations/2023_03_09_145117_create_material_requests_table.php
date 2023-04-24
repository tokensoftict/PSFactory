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
        Schema::create('material_requests', function (Blueprint $table) {
            $table->id();
            $table->date('request_date')->nullable();
            $table->time('request_time')->nullable();
            $table->unsignedBigInteger('request_by_id')->nullable();
            $table->nullableMorphs("request");
            $table->text('description')->nullable();
            $table->foreignId("status_id")->nullable()->constrained()->nullOnDelete();
            $table->foreign('request_by_id')->on('users')->references('id')->nullOnDelete();
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
        Schema::dropIfExists('material_requests');
        Schema::enableForeignKeyConstraints();
    }
};
