<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMainColorAndSecondaryColorColumnsToBrandbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brandbooks', function (Blueprint $table) {
            $table->string('main_color_hex')->nullable();
            $table->string('secondary_color_hex')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brandbooks', function (Blueprint $table) {
            $table->dropColumn('main_color_hex');
            $table->dropColumn('secondary_color_hex');
        });
    }
}
