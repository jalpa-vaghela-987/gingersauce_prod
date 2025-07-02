<?php

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name'                  => 'users',
                'slug' => 'users',
                'display_name_singular' => 'User',
                'display_name_plural' => 'Users',
                'icon'                  => 'voyager-person',
                'model_name'            => 'TCG\\Voyager\\Models\\User',
                'policy_name'           => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller'            => 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController',
                'description'           => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            1 => 
            array (
                'id' => 2,
                'name'                  => 'menus',
                'slug' => 'menus',
                'display_name_singular' => 'Menu',
                'display_name_plural' => 'Menus',
                'icon'                  => 'voyager-list',
                'model_name'            => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller'            => '',
                'description'           => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            2 => 
            array (
                'id' => 3,
                'name'                  => 'roles',
                'slug' => 'roles',
                'display_name_singular' => 'Role',
                'display_name_plural' => 'Roles',
                'icon'                  => 'voyager-lock',
                'model_name'            => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller'            => '',
                'description'           => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2019-11-09 09:58:52',
                'updated_at' => '2019-11-09 09:58:52',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'industries',
                'slug' => 'industries',
                'display_name_singular' => 'Industry',
                'display_name_plural' => 'Industries',
                'icon' => NULL,
                'model_name' => 'App\\Industry',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2019-11-09 10:01:27',
                'updated_at' => '2020-03-10 08:41:27',
            ),
            4 => 
            array (
                'id' => 6,
                'name' => 'industry_relations',
                'slug' => 'industry-relations',
                'display_name_singular' => 'Industry Relation',
                'display_name_plural' => 'Industry Relations',
                'icon' => NULL,
                'model_name' => 'App\\IndustryRelation',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2019-11-09 10:02:09',
                'updated_at' => '2019-11-09 10:06:03',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'packages',
                'slug' => 'packages',
                'display_name_singular' => 'Package',
                'display_name_plural' => 'Packages',
                'icon' => NULL,
                'model_name' => 'App\\Package',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}',
                'created_at' => '2019-12-30 10:31:03',
                'updated_at' => '2019-12-30 10:31:03',
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'invoices',
                'slug' => 'invoices',
                'display_name_singular' => 'Invoice',
                'display_name_plural' => 'Invoices',
                'icon' => NULL,
                'model_name' => 'App\\Invoice',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}',
                'created_at' => '2019-12-30 10:31:33',
                'updated_at' => '2019-12-30 10:31:33',
            ),
            7 => 
            array (
                'id' => 9,
                'name' => 'coupons',
                'slug' => 'coupons',
                'display_name_singular' => 'Coupon',
                'display_name_plural' => 'Coupons',
                'icon' => NULL,
                'model_name' => 'App\\Coupon',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}',
                'created_at' => '2020-03-22 21:46:36',
                'updated_at' => '2020-03-22 21:46:36',
            ),
            8 => 
            array (
                'id' => 10,
                'name' => 'themes',
                'slug' => 'themes',
                'display_name_singular' => 'Theme',
                'display_name_plural' => 'Themes',
                'icon' => 'voyager-paint-bucket',
                'model_name' => 'App\\Theme',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2020-03-22 21:47:16',
                'updated_at' => '2020-04-14 18:36:21',
            ),
            9 => 
            array (
                'id' => 11,
                'name' => 'credit_logs',
                'slug' => 'credit-logs',
                'display_name_singular' => 'Credit Log',
                'display_name_plural' => 'Credit Logs',
                'icon' => NULL,
                'model_name' => 'App\\CreditLog',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}',
                'created_at' => '2020-04-05 16:40:24',
                'updated_at' => '2020-04-05 16:40:24',
            ),
        ));
        

}
}