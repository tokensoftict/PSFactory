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
        Schema::create('stockbincards', function (Blueprint $table) {
            $table->id();
            $table->foreignId("stock_id")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId("stockbatch_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("user_id")->nullable()->constrained()->nullOnDelete();
            $table->date('date_added');
            $table->bigInteger("in")->default(0);
            $table->bigInteger("out")->default(0);
            $table->bigInteger("sold")->default(0);
            $table->bigInteger("return")->default(0);
            $table->bigInteger("pieces")->default(0);
            $table->bigInteger('total')->default(0);
            $table->bigInteger('total_pieces')->default(0);
            $table->enum("type",['RECEIVED','TRANSFER','SOLD','RETURN']);
            $table->mediumText('comment')->nullable();

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
        Schema::dropIfExists('stockbincards');
        Schema::enableForeignKeyConstraints();

    }
};
