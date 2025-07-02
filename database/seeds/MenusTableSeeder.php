<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
            'name' => 'admin',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
        ));
        
        
}
}