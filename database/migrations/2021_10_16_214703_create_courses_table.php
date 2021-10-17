<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('section_id')
            ->foreign('section_id')
            ->references('id')
            ->on('sections');

            $table->unsignedbigInteger('degree_id')
            ->foreign('degree_id')
            ->references('id')
            ->on('degrees');

            $table->string('period', 20);
            $table->enum('status', ['active', 'finished']);

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
        Schema::dropIfExists('courses');
    }
}
