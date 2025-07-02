<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brandbooks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brand')->nullable();
            $table->string('tag')->nullable();
            $table->string('type')->nullable();
            $table->string('state')->nullable();
            $table->bigInteger('industry_level_1')->nullable();
            $table->bigInteger('industry_level_2')->nullable();
            $table->text('logo')->nullable();
            $table->text('logo_b64')->nullable();
            $table->text('icon')->nullable();
            $table->text('icon_b64')->nullable();
            $table->json('approved')->nullable();
            $table->json('rejected')->nullable();
            $table->json('approved_icon')->nullable();
            $table->json('rejected_icon')->nullable();
            $table->string('proportions')->nullable();
            $table->string('space')->nullable();
            $table->string('size')->nullable();
            $table->string('color_scheme_mode')->nullable();
            $table->json('generated_colors')->nullable();
            $table->json('colors_used')->nullable();
            $table->json('fonts_main')->nullable();
            $table->json('fonts_secondary')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->json('core_values')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brandbooks');
    }
}
