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
        Schema::create('independent_tests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('introduction_text');
            $table->integer('pass_marks');
            $table->text('passing_comments');
            $table->integer('time')->default(0);
            $table->text('failing_comments');
            $table->boolean('show_scores')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('independent_tests');
    }
};
