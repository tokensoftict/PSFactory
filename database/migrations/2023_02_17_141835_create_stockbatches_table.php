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
        Schema::create('stockbatches', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('production_id')->nullable();
            $table->decimal("pieces")->default(0);
            $table->string('batch_number')->nullable();
            $table->date("received_date")->nullable();
            $table->date("expiry_date")->nullable();
            $table->decimal("quantity")->default(0);
            $table->foreignId("stock_id")->nullable()->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('stockbatches');
        Schema::enableForeignKeyConstraints();

    }
};
