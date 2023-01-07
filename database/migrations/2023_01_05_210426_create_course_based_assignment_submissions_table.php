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
        Schema::create('course_based_assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->integer('assignment_id');
            $table->integer('student_id');
            $table->string('file_name')->nullable();
            $table->integer('mark')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('course_based_assignment_submissions');
    }
};
