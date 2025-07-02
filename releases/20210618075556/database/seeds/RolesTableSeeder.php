<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Administrator',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'user',
                'display_name' => 'Normal User',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Super Admin',
                'display_name' => 'Administrator',
                'created_at' => '2019-11-11 12:33:20',
                'updated_at' => '2019-11-11 12:33:36',
            ),
        ));
        
        
}
}