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
        Schema::create('individual_test_descriptive_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('quiz_id');
            $table->integer('question_id');
            $table->string('answer');
            $table->integer('mark');
            $table->integer('status');
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
        Schema::dropIfExists('individual_test_descriptive_answers');
    }
};
