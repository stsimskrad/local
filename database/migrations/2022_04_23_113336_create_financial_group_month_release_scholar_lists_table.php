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
        Schema::create('financial_group_month_release_scholar_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->decimal('amount',12,2);
            $table->string('release_type',15);
            $table->string('dv_no')->nullable();
            $table->tinyInteger('benefit_id')->unsigned()->index();
            $table->foreign('benefit_id')->references('id')->on('list_benefits')->onDelete('cascade');
            $table->integer('scholar_id')->unsigned()->index();
            $table->foreign('scholar_id')->references('id')->on('financial_group_month_release_scholars')->onDelete('cascade');
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
        Schema::dropIfExists('financial_group_month_release_scholar_lists');
    }
};
