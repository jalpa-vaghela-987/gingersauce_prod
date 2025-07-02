<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('position')->nullable();
            $table->text('description')->nullable();
            $table->text('company_logo')->nullable();
            $table->string('company_web')->nullable();
            $table->string('company_dribble')->nullable();
            $table->string('company_behance')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('position');
            $table->dropColumn('description');
            $table->dropColumn('company_logo');
            $table->dropColumn('company_web');
            $table->dropColumn('company_dribble');
            $table->dropColumn('company_behance');
            $table->dropColumn('company_phone');
            $table->dropColumn('company_email');
        });
    }
}
