<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookExtendsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        Schema::create( 'book_extends', function ( Blueprint $table ){
            $table->bigIncrements( 'id' );
            $table->integer( 'duration' )->comment('years');
            $table->double( 'price' );
            $table->integer('save')->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        Schema::dropIfExists( 'book_extends' );
    }
}
