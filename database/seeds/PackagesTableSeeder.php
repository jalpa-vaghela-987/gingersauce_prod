<?php

use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('packages')->delete();
        
        \DB::table('packages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'On the House',
                'title' => 'Free',
                'language' => 'en',
                'credits' => 1,
                'created_at' => NULL,
                'updated_at' => '2019-12-26 21:38:54',
                'color' => '#dadada',
                'upper_title' => NULL,
                'lower_title' => 'Create, manage and present your brand books',
                'price' => '0.00',
                'description' => '<ul class="text-left" style="box-sizing: border-box; margin: 0px; padding: 0px; color: #212529; font-family: Montserrat, sans-serif; font-size: 14.4px;">
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Single editor</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Export to PDF</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Store &amp; edit for 30 days</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Manage your brands</strong></li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Online Brand Book templates</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Best in class logo rules including proportions, clear space and minimum size</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Font specifications</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Color palette generator</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic logo misuse variations</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Icon/Favicon specifications</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic logo file creator in png, jpg, pdf</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic Icon/Favicon creator in png, jpg, pdf</li>
</ul>',
                'position' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Sweet Soy',
                'title' => '$69',
                'language' => 'en',
                'credits' => 1,
                'created_at' => '2019-12-26 21:39:00',
                'updated_at' => '2019-12-26 22:02:19',
                'color' => '#ffd459',
                'upper_title' => NULL,
                'lower_title' => 'Create, manage and present your brand books',
                'price' => '69.00',
                'description' => '<ul class="text-left" style="box-sizing: border-box; margin: 0px; padding: 0px; color: #212529; font-family: Montserrat, sans-serif; font-size: 14.4px;">
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Single editor</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Privacy control</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Export to PDF</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Access to all features</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Store &amp; edit for 45 days</strong></li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Online Brand Book templates</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Best in class logo rules including proportions, clear space and minimum size</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Font specifications</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Color palette generator</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic logo misuse variations</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Icon/Favicon specifications</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic logo file creator in png, jpg, pdf</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic Icon/Favicon creator in png, jpg, pdf</li>
</ul>',
                'position' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Spicy Wasabi',
                'title' => '$552',
                'language' => 'en',
                'credits' => 10,
                'created_at' => '2019-12-26 21:41:53',
                'updated_at' => '2019-12-26 21:41:53',
                'color' => '#29b473',
                'upper_title' => 'Save 20%',
                'lower_title' => 'Create, manage and present your brand books',
                'price' => '552.00',
                'description' => '<ul class="text-left" style="box-sizing: border-box; margin: 0px; padding: 0px; color: #212529; font-family: Montserrat, sans-serif; font-size: 14.4px;">
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Multiple editors per brand</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Privacy control</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Export to PDF</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Access to all features</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Store &amp; edit for 60 days</strong></li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Online Brand Book templates</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Best in class logo rules including proportions, clear space and minimum size</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Font specifications</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Color palette generator</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic logo misuse variations</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Icon/Favicon specifications</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic logo file creator in png, jpg, pdf</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic Icon/Favicon creator in png, jpg, pdf</li>
</ul>',
                'position' => 2,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Hot Chilli',
                'title' => '$4,599',
                'language' => 'en',
                'credits' => 100,
                'created_at' => '2019-12-26 21:43:08',
                'updated_at' => '2019-12-26 21:43:08',
                'color' => '#ee6636',
                'upper_title' => 'Save 33%',
                'lower_title' => 'Create, manage and present your brand books',
                'price' => '4599.00',
                'description' => '<ul class="text-left" style="box-sizing: border-box; margin: 0px; padding: 0px; color: #212529; font-family: Montserrat, sans-serif; font-size: 14.4px;">
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Multiple editors per brand</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Privacy control</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Export to PDF</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Access to all features</strong></li>
<li class="font-weight-bold" style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;"><strong>Store &amp; edit for 75 days</strong></li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Online Brand Book templates</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Best in class logo rules including proportions, clear space and minimum size</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Font specifications</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Color palette generator</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic logo misuse variations</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Icon/Favicon specifications</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic logo file creator in png, jpg, pdf</li>
<li style="box-sizing: border-box; font-size: 14px; list-style: none; margin-bottom: 10px; display: flex;">Automatic Icon/Favicon creator in png, jpg, pdf</li>
</ul>',
                'position' => 3,
            ),
        ));
        
        
    }
}