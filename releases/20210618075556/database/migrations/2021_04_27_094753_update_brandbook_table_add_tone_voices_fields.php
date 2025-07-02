<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBrandbookTableAddToneVoicesFields extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table( 'brandbooks', function ( Blueprint $table ) {
            $table->string( 'voices' )->after( 'mockups' )->default( serialize( [] ) );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'brandbooks', function ( Blueprint $table ) {
            $table->dropColumn('voices');
        } );
    }
}
