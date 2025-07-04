<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'feedback', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->integer( 'user_id' );
            $table->text( 'feedback' );
            $table->boolean( 'answered' )->default( 0 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'feedback' );
    }
}
