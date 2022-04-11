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
        Schema::create('school_semesters', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->year('academic_year',20);
            $table->date('start_at');
            $table->date('end_at');
            $table->tinyInteger('semester_id')->unsigned()->index();
            $table->foreign('semester_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->integer('school_id')->unsigned()->index();
            $table->foreign('school_id')->references('id')->on('school_campuses')->onDelete('cascade');
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
        Schema::dropIfExists('school_semesters');
    }
};
