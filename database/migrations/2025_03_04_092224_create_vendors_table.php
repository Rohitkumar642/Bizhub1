<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('gst_no')->unique();
            $table->string('vendor_email')->unique();
            $table->string('legal_name');
            $table->string('duty')->nullable();
            $table->date('registration')->nullable();
            $table->string('company_type');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('trade_name')->nullable();
            $table->string('nature_business');
            $table->text('address');
            $table->string('district');
            $table->string('state');
            $table->string('pin_code', 6);
            $table->string('otp')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};
