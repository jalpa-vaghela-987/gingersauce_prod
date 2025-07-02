<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('book_id')->unsigned();
            $table->foreign('book_id')->references('id')->on('brandbooks')->onDelete('cascade');
            $table->string('title');
            $table->string('icon');
            $table->string('slug');
            $table->integer('order');
            $table->boolean('is_default')->default(false);
            $table->enum('status', ['active', 'deactive'])->default('active')->comment('See ActiveDeactiveStatus');
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
        Schema::dropIfExists('tabs');
    }
}
