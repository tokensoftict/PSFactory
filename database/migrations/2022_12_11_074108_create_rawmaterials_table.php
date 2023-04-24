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
        Schema::create('rawmaterials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("name");
            $table->decimal("measurement")->default(0);
            $table->decimal("cost_price",20,5)->default(0);
            $table->string("description")->nullable();
            $table->foreignId("materialtype_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("department_id")->nullable()->constrained()->nullOnDelete();
            $table->boolean('expiry')->default(1);
            $table->boolean('status')->default(1)->index()->comment('0=disabled, 1=enabled');
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
        Schema::dropIfExists('rawmaterials');
        Schema::enableForeignKeyConstraints();
    }
};
