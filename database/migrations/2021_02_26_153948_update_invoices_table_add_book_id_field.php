<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoicesTableAddBookIdField extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        Schema::table( 'invoices', function ( Blueprint $table ){

            $table->integer( 'book_id' )->nullable()->after( 'package_id' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        Schema::table( 'invoices', function ( Blueprint $table ){

            $table->dropColumn( 'book_id' );
        } );
    }
}
