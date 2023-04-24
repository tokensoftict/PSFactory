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
        Schema::create('stockopenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("stock_id")->constrained()->cascadeOnDelete();
            $table->bigInteger("quantity")->default(0);
            $table->decimal("average_cost_price",20,5)->nullable();
            $table->date('date_added');
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
        Schema::dropIfExists('stockopenings');
        Schema::enableForeignKeyConstraints();
    }
};
