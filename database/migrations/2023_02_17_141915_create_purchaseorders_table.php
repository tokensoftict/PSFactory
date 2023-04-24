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
        Schema::create('purchaseorders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId("supplier_id")->nullable()->constrained()->nullOnDelete();
            $table->date("date_created")->nullable();
            $table->date("date_completed")->nullable();
            $table->date('purchase_date')->nullable();
            $table->foreignId("department_id")->nullable()->constrained()->nullOnDelete();
            $table->nullableMorphs("purchase");
            $table->string("reference")->nullable();
            $table->decimal('total',20,5)->default(0);
            $table->foreignId('status_id')->default(1)->constrained();
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->unsignedBigInteger("completed_by")->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('completed_by')->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('purchaseorders');
        Schema::enableForeignKeyConstraints();
    }
};
