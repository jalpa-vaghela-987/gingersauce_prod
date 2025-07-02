<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableChangeCredtisExpiryFieldName extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->dropColumn('credits_charge_date_ts');
            $table->timestamp('credits_expire_date_at')->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->dropColumn('credits_expire_date_at');
            $table->integer('credits_charge_date_ts');
        } );
    }
}
