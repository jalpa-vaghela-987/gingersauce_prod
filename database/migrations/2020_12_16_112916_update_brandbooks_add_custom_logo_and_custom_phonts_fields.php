<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBrandbooksAddCustomLogoAndCustomPhontsFields extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        Schema::table( 'brandbooks', function ( Blueprint $table ){

            $table->string( 'custom_logo' )->nullable();
            $table->string( 'custom' )->after( 'custom_logo' )->default( serialize( [] ) );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        Schema::table( 'brandbooks', function ( Blueprint $table ){

            $table->dropColumn( 'custom_logo' );
            $table->dropColumn( 'custom' );
        } );
    }
}
