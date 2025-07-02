<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('color')->nullable();
            $table->string('upper_title')->nullable();
            $table->string('lower_title')->nullable();
            $table->decimal('price', 10, 2)->default(0.0);
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->dropColumn('upper_title');
            $table->dropColumn('lower_title');
            $table->dropColumn('price');
            $table->dropColumn('description');
        });
    }
}
