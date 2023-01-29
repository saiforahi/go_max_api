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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person');
            $table->string('company_email');
            $table->string("distributor");
            $table->string("country");
            $table->string("city");
            $table->string("district");
            $table->string("thana");
            $table->string("father_name");
            $table->string("mother_name");
            $table->string("spouse_name");
            $table->string("spouse_phone");
            $table->date("birth_date");
            $table->string("sms_phone");
            $table->string("mobile");
            $table->string("nid");
            $table->string("passport");
            $table->longText('present_address');
            $table->longText('billing_address');
            $table->longText('permanent_address');
            $table->unsignedBigInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users');
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
        Schema::dropIfExists('merchants');
    }
};
