<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBrandbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'brandbooks',
            function ( Blueprint $table ) {
                $table->longtext( 'logo' )
                      ->nullable()
                      ->change();
                $table->longtext( 'logo_b64' )
                      ->nullable()
                      ->change();
                $table->longtext( 'old_logo' )
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
        Schema::table( 'brandbooks',
            function ( Blueprint $table ) {
                $table->text( 'logo' )
                      ->nullable()
                      ->change();
                $table->text( 'logo_b64' )
                      ->nullable()
                      ->change();
                $table->text( 'old_logo' )
                      ->nullable()
                      ->change();
            } );
    }
}
