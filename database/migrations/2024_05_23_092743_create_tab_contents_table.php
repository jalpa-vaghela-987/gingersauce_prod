<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tab_id')->unsigned();
            $table->foreign('tab_id')->references('id')->on('tabs')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->enum('status', ['active', 'deactive'])->default('active')->comment('See ActiveDeactiveStatus');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tab_contents');
    }
}
