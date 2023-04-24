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
        Schema::create('production_template_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rawmaterial_id')->constrained()->cascadeOnDelete();
            $table->foreignId('production_template_id')->constrained()->cascadeOnDelete();
            $table->string("unit")->nullable();
            $table->date('date_created');
            $table->decimal('measurement',20,8);
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
        Schema::dropIfExists('production_template_items');
        Schema::enableForeignKeyConstraints();
    }
};
