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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->date("production_date");
            $table->date("expiry_date")->nullable();
            $table->foreignId('stock_id')->constrained()->cascadeOnDelete();
            $table->foreignId('productionline_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('production_template_id')->constrained()->cascadeOnDelete();
            $table->foreignId('material_request_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('expected_quantity')->default(0);
            $table->decimal('rough_quantity')->default(0);
            $table->decimal('yield_quantity')->default(0);
            $table->string('batch_number')->nullable();
            $table->decimal('quantity_1')->default(0);
            $table->decimal('quantity_2')->default(0);
            $table->decimal('quantity_3')->default(0);
            $table->time("production_time")->nullable();
            $table->foreignId("status_id")->constrained();
            $table->text("remark")->nullable();
            $table->foreignId("user_id")->constrained();
            $table->unsignedBigInteger("completed_id")->nullable();
            $table->foreign("completed_id")->references("id")->on("users")->nullOnDelete();
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
        Schema::dropIfExists('productions');
        Schema::enableForeignKeyConstraints();
    }
};
