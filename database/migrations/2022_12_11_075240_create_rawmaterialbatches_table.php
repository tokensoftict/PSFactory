<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rawmaterialbatches', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->date("received_date")->nullable();
            $table->date("expiry_date")->nullable();
            $table->decimal("measurement",20,5)->default(0);
            $table->foreignId("rawmaterial_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("supplier_id")->nullable()->constrained()->nullOnDelete();
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
        Schema::dropIfExists('rawmaterialbatches');
        Schema::enableForeignKeyConstraints();
    }
};
