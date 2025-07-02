<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoicesTableAddTypeField extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        Schema::table( 'invoices', function ( Blueprint $table ){

            $table->enum( 'type', [ 'book', 'package', 'upgrade' ] )->default( 'package' )->after( 'book_id' );
            $table->integer( 'package_from_id' )->after('package_id')->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        Schema::table( 'invoices', function ( Blueprint $table ){

            $table->dropColumn( 'type' );
            $table->dropColumn( 'package_from_id' );
        } );
    }
}
