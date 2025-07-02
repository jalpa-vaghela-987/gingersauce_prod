<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvatarToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'avatar')){
            Schema::table('users', function (Blueprint $table) {
                $table->string('avatar')->nullable();
            });
        }
        if (!Schema::hasColumn('users', 'avatar_original')){
            Schema::table('users', function (Blueprint $table) {
                $table->string('avatar_original')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'avatar')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('avatar');
            });
        }
        if (Schema::hasColumn('users', 'avatar_original')){
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('avatar_original');
            });
        }
    }
}
