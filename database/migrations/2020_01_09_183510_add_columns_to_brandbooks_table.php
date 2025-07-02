<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBrandbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brandbooks', function (Blueprint $table) {
            $table->string('introduction_title')->nullable();//->default('Introduction');
            $table->text('introduction_text')->nullable();//->default('<p>Welcome to the official brand guidelines of the {{brand}} brand and assets. This document is intended to educate anyone who is responsible for creating internal or external communications using the {{brand}} brand.</p><p>It is important that we all share a basic understanding of how and when to use our identity. These Identity Standards are intended to introduce you to the basic usage. We want to make it easy for you to integrate {{brand}} in all media formats while respecting our brand and legal/licensing restrictions.</p><p>Note that by using these resources, you accept our Terms of Service. Usage of these resources may also be covered by the {{brand}} End User Agreement and our Privacy Policy.</p>');

            $table->string('vision_title')->nullable();//->default('Vision');
            $table->text('vision_text')->nullable();//->default('');

            $table->string('mission_title')->nullable();//->default('Mission');
            $table->text('mission_text')->nullable();//->default('');

            $table->string('core_title')->nullable();//->default('Mission');
            $table->text('core_text')->nullable();//->default('<p>Company values matter. Every successful company has a set of company values to assist their employees in achieving their goals as well as the company`s. They are the essence of the company`s identity and summarises the purpose of their existence. Company values are a guide on how the company should run and they are normally integrated in the company`s mission statement. Companies should try to establish their company values as a team instead of just the leader or management. By doing so, everyone in the company would feel belong and they would feel needed and not neglected.</p>');

            $table->string('logo_title')->nullable();//->default('Our Logo');
            $table->text('logo_text')->nullable();//->default('<p>We are very proud of our logo, and we require that you follow these guidelines to ensure it always looks its best.</p>');

            $table->string('versions_title')->nullable();//->default('Logo Versions');
            $table->text('versions_text')->nullable();//->default('<p>The {{brand}} Logo should be used mostly with the {{color_0}} and {{color_1}} colors. The negative {{brand}} Logo can be used on dark image backgounds with high contrast between them.<br>The Monochrome version logo should be used on documents that are printed in black & white.</p>');

            $table->string('icon_title')->nullable();//->default('Our Icon & Favicon');
            $table->text('icon_text')->nullable();//->default('The {{brand}} icon should be used as the official Favicon only in {{brand}} {{color_0}}. The negative icon should be used for social as user/company image such as Whatsapp, Facebook, LinkedIn etc.');

            $table->string('proportions_title')->nullable();//->default('Logo & Icon Proportions');
            $table->text('proportions_text')->nullable();//->default('The {{brand}} Logo has a neat proportion of 4:1 width. These proportions were chosen carefully and they are not to be changed. The Icon has a perfect square proportion of 1:1 and acts as the Favicon as well.');

            $table->string('space_title')->nullable();//->default('Clear Space');
            $table->text('space_text')->nullable();//->default('Clear space is the area surrounding the global signature and Icon that must be kept free of any elements, including text, graphics, borders, or other logos. The minimum clear space required for the preferred global signature is equal to &quot;x&quot;, or the height and width of the {{brand}} Icon');

            $table->string('size_title')->nullable();//->default('Minimum Size');
            $table->text('size_text')->nullable();//->default('Establishing a minimum size ensures that the impact and legibility of the logo is not compromised in application.');

            $table->string('misuse_title')->nullable();//->default('Logo Misuse');
            $table->text('misuse_text')->nullable();//->default('It is important that the appearance of the logo remains consistent. The logo should not be misinterpreted, modified, or added to. No attempt should be made to alter the logo in any way. Its orientation, colour and composition should remain as indicated in this document &mdash; there are no exceptions.');

            $table->string('pallette_title')->nullable();//->default('Our Color Pallete');
            $table->text('pallette_text')->nullable();//->default('The colors selected for the {{brand}} signature reflect the company`s values. The colors have been specifically chosen to represent the brand and should not be altered under any circumstance.<br> For Printing instances, a Rich Black should be used for text with C40 M10 Y0 K100.');
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
            $table->dropColumn('introduction_title');
            $table->dropColumn('introduction_text');
            $table->dropColumn('vision_title');
            $table->dropColumn('vision_text');
            $table->dropColumn('mission_title');
            $table->dropColumn('mission_text');
            $table->dropColumn('core_title');
            $table->dropColumn('core_text');
            $table->dropColumn('logo_title');
            $table->dropColumn('logo_text');
            $table->dropColumn('versions_title');
            $table->dropColumn('versions_text');
            $table->dropColumn('icon_title');
            $table->dropColumn('icon_text');
            $table->dropColumn('proportions_title');
            $table->dropColumn('proportions_text');
            $table->dropColumn('space_title');
            $table->dropColumn('space_text');
            $table->dropColumn('size_title');
            $table->dropColumn('size_text');
            $table->dropColumn('misuse_title');
            $table->dropColumn('misuse_text');
            $table->dropColumn('pallette_title');
            $table->dropColumn('pallette_text');
        });
    }
}
