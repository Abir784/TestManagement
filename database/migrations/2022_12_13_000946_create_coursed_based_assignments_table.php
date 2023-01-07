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
        Schema::create('coursed_based_assignments', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->integer('batch_id');
            $table->integer('file_name')->nullable();
            $table->string('title')->nullable();
            $table->integer('full_marks');
            $table->date('deadline');
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
        Schema::dropIfExists('coursed_based_assignments');
    }
};
