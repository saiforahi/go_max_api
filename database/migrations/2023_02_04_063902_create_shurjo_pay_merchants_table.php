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
        Schema::create('shurjo_pay_merchants', function (Blueprint $table) {
            $table->id();
            $table->string("alias_name");
            $table->string("live_api_username");
            $table->string("live_api_password");
            $table->string("live_prefix");
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
        Schema::dropIfExists('shurjo_pay_merchants');
    }
};
