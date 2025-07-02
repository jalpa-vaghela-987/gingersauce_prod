<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllLogoVariationsToBrandbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brandbooks', function (Blueprint $table) {
            $table->json('all_logo_variations')->nullable();
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
            $table->dropColumn('all_logo_variations');
        });
    }
}
