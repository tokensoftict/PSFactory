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
        Schema::create('rawmaterialopenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("rawmaterial_id")->constrained()->cascadeOnDelete();
            $table->decimal("measurement")->default(0);
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
        Schema::dropIfExists('rawmaterialopenings');
        Schema::enableForeignKeyConstraints();
    }
};
