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
        Schema::create('stocks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->mediumText('name')->nullable();
            $table->text("description")->nullable();
            $table->string("code",255)->nullable();
            $table->decimal('incentives_percentage')->default(0);
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal("selling_price",20,5)->nullable()->default(0);
            $table->decimal("cost_price",20,5)->nullable()->default(0);
            $table->boolean("expiry")->default("0");
            $table->integer("carton")->default(0);
            $table->boolean("status")->default("1");
            $table->decimal("quantity")->default(0);
            $table->decimal("pieces")->default(0);
            $table->string("image")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->timestamps();

            $table->foreign("user_id")
                ->references("id")->on('users')->onDelete("set null");

            $table->foreign("last_updated_by")
                ->references("id")->on('users')->onDelete("set null");

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
        Schema::dropIfExists('stocks');
        Schema::enableForeignKeyConstraints();
    }
};
