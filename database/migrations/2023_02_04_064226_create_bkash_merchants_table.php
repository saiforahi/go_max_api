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
        Schema::create('bkash_merchants', function (Blueprint $table) {
            $table->id();
            $table->string("alias_name");
            $table->string("reference_merchant_id");
            $table->string("merchant_mcc");
            $table->string("merchant_name");
            $table->string("merchant_city");
            $table->string("merchant_region");
            $table->string("merchant_store_reference_id");
            $table->string("merchant_store_mcc");
            $table->string("merchant_store_name");
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
        Schema::dropIfExists('bkash_merchants');
    }
};
