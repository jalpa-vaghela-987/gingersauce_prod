<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStoredUserCardsAddDefaultUseField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cc_stored_user_cards', function (Blueprint $table) {
            $table->boolean('default')->default(0)->after('token');
            $table->string('name_on_card')->nullable()->after('default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cc_stored_user_cards', function (Blueprint $table) {
            $table->dropColumn('default');
            $table->dropColumn('name_on_card');
        });
    }
}
