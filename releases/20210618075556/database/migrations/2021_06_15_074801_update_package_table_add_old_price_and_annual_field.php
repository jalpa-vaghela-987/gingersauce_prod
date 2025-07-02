<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePackageTableAddOldPriceAndAnnualField extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table( 'packages', function ( Blueprint $table ) {
            $table->boolean( 'prolong' )->default( 0 );
            $table->decimal( 'old_price', 10, 2 )->nullable();
            $table->decimal( 'annual_old_price', 10, 2 )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'packages', function ( Blueprint $table ) {
            $table->dropColumn( 'prolong' );
            $table->dropColumn( 'old_price' );
            $table->dropColumn( 'annual_old_price' );
        } );
    }
}
