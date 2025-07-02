<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcStoredUserCards extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        Schema::create( 'cc_stored_user_cards', function ( Blueprint $table ){

            $table->bigIncrements( 'id' );
            $table->bigInteger( 'user_id' );
            $table->integer( 'client_id' );
            $table->string( 'buyer_card_mask' );
            $table->string( 'custom_client_id' );
            $table->string( 'cc_card_type' );
            $table->integer( 'token_id' );
            $table->string( 'token' );
            $table->timestamps();

        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        Schema::dropIfExists( 'cc_stored_user_cards' );
    }
}
