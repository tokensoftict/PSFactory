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
        Schema::create('nearoutofstocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId("stock_id")->constrained()->cascadeOnDelete();
            $table->enum('threshold_type',['NORMAL','THRESHOLD']);
            $table->bigInteger('toBuy');
            $table->decimal('threshold')->nullable();
            $table->decimal('quantity')->nullable(); //current quantity
            $table->decimal('sold')->nullable();
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
        Schema::dropIfExists('nearoutofstocks');
        Schema::enableForeignKeyConstraints();

    }
};
