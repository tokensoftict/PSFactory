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
        Schema::create('rawmaterialbincards', function (Blueprint $table) {
            $table->id();
            $table->foreignId("rawmaterialbatch_id")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId("rawmaterial_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("user_id")->nullable()->constrained()->nullOnDelete();
            $table->date('date_added');
            $table->decimal("in", 20,5)->default(0);
            $table->decimal("out",20,5)->default(0);
            $table->decimal("return", 20,5)->default(0);
            $table->decimal('total', 20,5)->default(0);
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
        Schema::dropIfExists('rawmaterialbincards');
        Schema::enableForeignKeyConstraints();
    }
};
