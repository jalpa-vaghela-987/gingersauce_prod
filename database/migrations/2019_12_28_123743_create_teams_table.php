<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('teams')){
            Schema::create('teams', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->bigInteger('owner_id')->nullable();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('team_memebers')){
            Schema::create('team_memebers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('team_id')->nullable();
                $table->bigInteger('user_id')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('teams');
        Schema::dropIfExists('team_memebers');
    }
}
