<?php

use App\Models\PaymentService;
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
        Schema::create('payment_services', function (Blueprint $table) {
            $table->id();
            $table->string('display_name')->unique();
            $table->string('name')->unique();
            $table->timestamps();
        });
        $shurjopay=PaymentService::create([
            "display_name"=>"ShurjoPay",
            "name"=>"ShurjoPay"
        ]);
        $shurjopay->addMedia(public_path('/images/shurjo-logo.png'))->toMediaCollection('photo');
        $bkash=PaymentService::create([
            "display_name"=>"bKash",
            "name"=>"bKash"
        ]);
        $bkash->addMedia(public_path('/images/bkash-logo.jpg'))->toMediaCollection('photo');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_services');
    }
};
