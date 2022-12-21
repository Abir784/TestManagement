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
        Schema::create('course_based_tests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('course_id');
            $table->integer('batch_id');
            $table->integer('time');
            $table->string('introduction_text');
            $table->string('passing_comments');
            $table->string('failing_comments');
            $table->integer('pass_marks');
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
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
        Schema::dropIfExists('course_based_tests');
    }
};
