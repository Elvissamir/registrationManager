<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_subject', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id')->foreign('student_id')->references('id')->on('students');
            $table->unsignedInteger('subject_id')->foreign('subject_id')->references('id')->on('subjects');
            $table->integer('first')->default(0);
            $table->integer('second')->default(0);
            $table->integer('third')->default(0);
            $table->integer('fourth')->default(0);
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
        Schema::dropIfExists('student_subject');
    }
}
