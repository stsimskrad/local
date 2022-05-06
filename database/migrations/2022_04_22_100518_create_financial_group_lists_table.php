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
        Schema::create('financial_group_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('count',3)->default(0);
            $table->boolean('is_first')->default(1);
            $table->boolean('is_hold')->default(0);
            $table->boolean('is_completed')->default(0);
            $table->date('start_at');
            $table->integer('group_id')->unsigned()->index();
            $table->foreign('group_id')->references('id')->on('financial_groups')->onDelete('cascade');
            $table->bigInteger('scholar_id')->unsigned()->index();
            $table->foreign('scholar_id')->references('id')->on('scholars')->onDelete('cascade');
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
        Schema::dropIfExists('financial_group_lists');
    }
};
