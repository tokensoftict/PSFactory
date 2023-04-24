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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['INDIVIDUAL','COMPANY']);
            $table->foreignId('state_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('company_name')->nullable();
            $table->string('contact_user')->nullable();
            $table->string('email')->nullable();
            $table->boolean('status')->nullable()->default(1);
            $table->mediumText('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->decimal('credit_balance', 20, 5)->default(0);
            $table->decimal('deposit_balance', 20, 5)->default(0);
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
        Schema::dropIfExists('customers');
        Schema::enableForeignKeyConstraints();
    }
};
