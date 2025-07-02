<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustryRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industry_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('term_id')->unsigned();
            $table->bigInteger('relation_id')->unsigned();
            $table->timestamps();

            $table->foreign('term_id')->references('id')->on('industries')->onDelete('cascade');
            $table->foreign('relation_id')->references('id')->on('industries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('industry_relations');
    }
}
