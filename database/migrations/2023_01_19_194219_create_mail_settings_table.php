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
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->id();
            $table->string('MAIL_MAILER');
            $table->string('MAIL_PORT');
            $table->string('MAIL_USERNAME');
            $table->string('MAIL_PASSWORD');
            $table->string('MAIL_ENCRYPTION');
            $table->string('MAIL_FROM_ADDRESS');
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
        Schema::dropIfExists('mail_settings');
    }
};
