<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableSetEmailNullable
    extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'users',
            function ( Blueprint $table ) {
                $table->dropUnique( [ 'email' ] );
                $table->string( 'email' )
                      ->unique()
                      ->nullable()
                      ->change();
            } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'users',
            function ( Blueprint $table ) {
                $table->dropUnique( [ 'email' ] );
                $table->string( 'email' )
                      ->unique()
                      ->change();
            } );
    }
}
