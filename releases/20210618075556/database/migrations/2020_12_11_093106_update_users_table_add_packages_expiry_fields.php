<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableAddPackagesExpiryFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->integer( 'package_credits' )->after( 'left_credits' )->default( 0 );
            $table->integer( 'credits_charge_date_ts' )->after( 'package_credits' )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->dropColumn( 'package_credits' );
            $table->dropColumn( 'credits_charge_date_ts' );
        } );
    }
}
