<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoicesTableAddPackageDurationTypeField extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        Schema::table( 'invoices', function ( Blueprint $table ){
            $table->boolean( 'annual' )->default( false )->after( 'price' );
            $table->decimal( 'refund' )->after( 'price' )->default( 0 );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        Schema::table( 'invoices', function ( Blueprint $table ){

            $table->dropColumn( 'annual' );
        } );
    }
}
