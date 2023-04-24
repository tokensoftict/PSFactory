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
        Schema::create('invoice_returns', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("return_number",255)->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId("status_id")->default(1)->constrained();
            $table->foreignId("invoice_returns_reason_id")->default(1)->constrained();
            $table->decimal("sub_total",20,5);
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("approved_by")->nullable();
            $table->date("return_date");
            $table->time("return_time");
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();

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
        Schema::dropIfExists('invoice_returns');
        Schema::enableForeignKeyConstraints();
    }
};
