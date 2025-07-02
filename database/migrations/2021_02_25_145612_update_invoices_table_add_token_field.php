<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoicesTableAddTokenField extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        Schema::table( 'invoices', function ( Blueprint $table ){

            $table->integer( 'token_id' )->after( 'user_id' )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        Schema::table( 'invoices', function ( Blueprint $table ){

            $table->dropColumn( 'token_id' );
        } );
    }
}
