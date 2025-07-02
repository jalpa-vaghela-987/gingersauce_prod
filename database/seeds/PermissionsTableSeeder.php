<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'browse_admin',
                'table_name' => NULL,
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'browse_bread',
                'table_name' => NULL,
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'browse_database',
                'table_name' => NULL,
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'browse_media',
                'table_name' => NULL,
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'browse_compass',
                'table_name' => NULL,
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'browse_menus',
                'table_name' => 'menus',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'read_menus',
                'table_name' => 'menus',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'edit_menus',
                'table_name' => 'menus',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'add_menus',
                'table_name' => 'menus',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => 'delete_menus',
                'table_name' => 'menus',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            10 => 
            array (
                'id' => 11,
                'key' => 'browse_roles',
                'table_name' => 'roles',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            11 => 
            array (
                'id' => 12,
                'key' => 'read_roles',
                'table_name' => 'roles',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            12 => 
            array (
                'id' => 13,
                'key' => 'edit_roles',
                'table_name' => 'roles',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            13 => 
            array (
                'id' => 14,
                'key' => 'add_roles',
                'table_name' => 'roles',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            14 => 
            array (
                'id' => 15,
                'key' => 'delete_roles',
                'table_name' => 'roles',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            15 => 
            array (
                'id' => 16,
                'key' => 'browse_users',
                'table_name' => 'users',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            16 => 
            array (
                'id' => 17,
                'key' => 'read_users',
                'table_name' => 'users',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            17 => 
            array (
                'id' => 18,
                'key' => 'edit_users',
                'table_name' => 'users',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            18 => 
            array (
                'id' => 19,
                'key' => 'add_users',
                'table_name' => 'users',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            19 => 
            array (
                'id' => 20,
                'key' => 'delete_users',
                'table_name' => 'users',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            20 => 
            array (
                'id' => 21,
                'key' => 'browse_settings',
                'table_name' => 'settings',
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            21 => 
            array (
                'id' => 22,
                'key' => 'read_settings',
                'table_name' => 'settings',
                'created_at' => '2019-11-09 09:58:53',
                'updated_at' => '2019-11-09 09:58:53',
            ),
            22 => 
            array (
                'id' => 23,
                'key' => 'edit_settings',
                'table_name' => 'settings',
                'created_at' => '2019-11-09 09:58:53',
                'updated_at' => '2019-11-09 09:58:53',
            ),
            23 => 
            array (
                'id' => 24,
                'key' => 'add_settings',
                'table_name' => 'settings',
                'created_at' => '2019-11-09 09:58:53',
                'updated_at' => '2019-11-09 09:58:53',
            ),
            24 => 
            array (
                'id' => 25,
                'key' => 'delete_settings',
                'table_name' => 'settings',
                'created_at' => '2019-11-09 09:58:53',
                'updated_at' => '2019-11-09 09:58:53',
            ),
            25 => 
            array (
                'id' => 26,
                'key' => 'browse_hooks',
                'table_name' => NULL,
                'created_at' => '2019-11-09 09:58:53',
                'updated_at' => '2019-11-09 09:58:53',
            ),
            26 => 
            array (
                'id' => 27,
                'key' => 'browse_industries',
                'table_name' => 'industries',
                'created_at' => '2019-11-09 10:01:27',
                'updated_at' => '2019-11-09 10:01:27',
            ),
            27 => 
            array (
                'id' => 28,
                'key' => 'read_industries',
                'table_name' => 'industries',
                'created_at' => '2019-11-09 10:01:27',
                'updated_at' => '2019-11-09 10:01:27',
            ),
            28 => 
            array (
                'id' => 29,
                'key' => 'edit_industries',
                'table_name' => 'industries',
                'created_at' => '2019-11-09 10:01:27',
                'updated_at' => '2019-11-09 10:01:27',
            ),
            29 => 
            array (
                'id' => 30,
                'key' => 'add_industries',
                'table_name' => 'industries',
                'created_at' => '2019-11-09 10:01:27',
                'updated_at' => '2019-11-09 10:01:27',
            ),
            30 => 
            array (
                'id' => 31,
                'key' => 'delete_industries',
                'table_name' => 'industries',
                'created_at' => '2019-11-09 10:01:27',
                'updated_at' => '2019-11-09 10:01:27',
            ),
            31 => 
            array (
                'id' => 32,
                'key' => 'browse_industry_relations',
                'table_name' => 'industry_relations',
                'created_at' => '2019-11-09 10:02:09',
                'updated_at' => '2019-11-09 10:02:09',
            ),
            32 => 
            array (
                'id' => 33,
                'key' => 'read_industry_relations',
                'table_name' => 'industry_relations',
                'created_at' => '2019-11-09 10:02:09',
                'updated_at' => '2019-11-09 10:02:09',
            ),
            33 => 
            array (
                'id' => 34,
                'key' => 'edit_industry_relations',
                'table_name' => 'industry_relations',
                'created_at' => '2019-11-09 10:02:09',
                'updated_at' => '2019-11-09 10:02:09',
            ),
            34 => 
            array (
                'id' => 35,
                'key' => 'add_industry_relations',
                'table_name' => 'industry_relations',
                'created_at' => '2019-11-09 10:02:09',
                'updated_at' => '2019-11-09 10:02:09',
            ),
            35 => 
            array (
                'id' => 36,
                'key' => 'delete_industry_relations',
                'table_name' => 'industry_relations',
                'created_at' => '2019-11-09 10:02:09',
                'updated_at' => '2019-11-09 10:02:09',
            ),
            36 => 
            array (
                'id' => 37,
                'key' => 'browse_packages',
                'table_name' => 'packages',
                'created_at' => '2019-12-30 10:31:04',
                'updated_at' => '2019-12-30 10:31:04',
            ),
            37 => 
            array (
                'id' => 38,
                'key' => 'read_packages',
                'table_name' => 'packages',
                'created_at' => '2019-12-30 10:31:04',
                'updated_at' => '2019-12-30 10:31:04',
            ),
            38 => 
            array (
                'id' => 39,
                'key' => 'edit_packages',
                'table_name' => 'packages',
                'created_at' => '2019-12-30 10:31:04',
                'updated_at' => '2019-12-30 10:31:04',
            ),
            39 => 
            array (
                'id' => 40,
                'key' => 'add_packages',
                'table_name' => 'packages',
                'created_at' => '2019-12-30 10:31:04',
                'updated_at' => '2019-12-30 10:31:04',
            ),
            40 => 
            array (
                'id' => 41,
                'key' => 'delete_packages',
                'table_name' => 'packages',
                'created_at' => '2019-12-30 10:31:04',
                'updated_at' => '2019-12-30 10:31:04',
            ),
            41 => 
            array (
                'id' => 42,
                'key' => 'browse_invoices',
                'table_name' => 'invoices',
                'created_at' => '2019-12-30 10:31:33',
                'updated_at' => '2019-12-30 10:31:33',
            ),
            42 => 
            array (
                'id' => 43,
                'key' => 'read_invoices',
                'table_name' => 'invoices',
                'created_at' => '2019-12-30 10:31:33',
                'updated_at' => '2019-12-30 10:31:33',
            ),
            43 => 
            array (
                'id' => 44,
                'key' => 'edit_invoices',
                'table_name' => 'invoices',
                'created_at' => '2019-12-30 10:31:33',
                'updated_at' => '2019-12-30 10:31:33',
            ),
            44 => 
            array (
                'id' => 45,
                'key' => 'add_invoices',
                'table_name' => 'invoices',
                'created_at' => '2019-12-30 10:31:33',
                'updated_at' => '2019-12-30 10:31:33',
            ),
            45 => 
            array (
                'id' => 46,
                'key' => 'delete_invoices',
                'table_name' => 'invoices',
                'created_at' => '2019-12-30 10:31:33',
                'updated_at' => '2019-12-30 10:31:33',
            ),
            46 => 
            array (
                'id' => 47,
                'key' => 'browse_coupons',
                'table_name' => 'coupons',
                'created_at' => '2020-03-22 21:46:36',
                'updated_at' => '2020-03-22 21:46:36',
            ),
            47 => 
            array (
                'id' => 48,
                'key' => 'read_coupons',
                'table_name' => 'coupons',
                'created_at' => '2020-03-22 21:46:36',
                'updated_at' => '2020-03-22 21:46:36',
            ),
            48 => 
            array (
                'id' => 49,
                'key' => 'edit_coupons',
                'table_name' => 'coupons',
                'created_at' => '2020-03-22 21:46:36',
                'updated_at' => '2020-03-22 21:46:36',
            ),
            49 => 
            array (
                'id' => 50,
                'key' => 'add_coupons',
                'table_name' => 'coupons',
                'created_at' => '2020-03-22 21:46:36',
                'updated_at' => '2020-03-22 21:46:36',
            ),
            50 => 
            array (
                'id' => 51,
                'key' => 'delete_coupons',
                'table_name' => 'coupons',
                'created_at' => '2020-03-22 21:46:36',
                'updated_at' => '2020-03-22 21:46:36',
            ),
            51 => 
            array (
                'id' => 52,
                'key' => 'browse_themes',
                'table_name' => 'themes',
                'created_at' => '2020-03-22 21:47:16',
                'updated_at' => '2020-03-22 21:47:16',
            ),
            52 => 
            array (
                'id' => 53,
                'key' => 'read_themes',
                'table_name' => 'themes',
                'created_at' => '2020-03-22 21:47:16',
                'updated_at' => '2020-03-22 21:47:16',
            ),
            53 => 
            array (
                'id' => 54,
                'key' => 'edit_themes',
                'table_name' => 'themes',
                'created_at' => '2020-03-22 21:47:16',
                'updated_at' => '2020-03-22 21:47:16',
            ),
            54 => 
            array (
                'id' => 55,
                'key' => 'add_themes',
                'table_name' => 'themes',
                'created_at' => '2020-03-22 21:47:16',
                'updated_at' => '2020-03-22 21:47:16',
            ),
            55 => 
            array (
                'id' => 56,
                'key' => 'delete_themes',
                'table_name' => 'themes',
                'created_at' => '2020-03-22 21:47:16',
                'updated_at' => '2020-03-22 21:47:16',
            ),
            56 => 
            array (
                'id' => 57,
                'key' => 'browse_credit_logs',
                'table_name' => 'credit_logs',
                'created_at' => '2020-04-05 16:40:24',
                'updated_at' => '2020-04-05 16:40:24',
            ),
            57 => 
            array (
                'id' => 58,
                'key' => 'read_credit_logs',
                'table_name' => 'credit_logs',
                'created_at' => '2020-04-05 16:40:24',
                'updated_at' => '2020-04-05 16:40:24',
            ),
            58 => 
            array (
                'id' => 59,
                'key' => 'edit_credit_logs',
                'table_name' => 'credit_logs',
                'created_at' => '2020-04-05 16:40:24',
                'updated_at' => '2020-04-05 16:40:24',
            ),
            59 => 
            array (
                'id' => 60,
                'key' => 'add_credit_logs',
                'table_name' => 'credit_logs',
                'created_at' => '2020-04-05 16:40:24',
                'updated_at' => '2020-04-05 16:40:24',
            ),
            60 => 
            array (
                'id' => 61,
                'key' => 'delete_credit_logs',
                'table_name' => 'credit_logs',
                'created_at' => '2020-04-05 16:40:24',
                'updated_at' => '2020-04-05 16:40:24',
            ),
        ));


}
}