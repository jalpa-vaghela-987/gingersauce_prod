<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePackagesTableAddCreditExpiryField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table( 'packages', function ( Blueprint $table ) {
            $table->integer( 'credit_expiry' )->after( 'credits' )->nullable();
            $table->integer( 'book_expiry' )->after( 'credit_expiry' )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'packages', function ( Blueprint $table ) {
            $table->dropColumn( 'credit_expiry' );
            $table->dropColumn( 'book_expiry' );
        } );
    }
}
