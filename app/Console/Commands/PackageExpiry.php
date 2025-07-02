<?php

namespace App\Console\Commands;

use App\Package;
use App\User;
use Carbon\Exceptions\Exception;
use Illuminate\Console\Command;

class PackageExpiry extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $this->expired();
    }

    protected function expired() {

        $packages_with_expire = Package::where( 'credit_expiry', '>', 0 )->get();
        $free_package         = Package::where( 'price', 0 )->first();

        if ( $packages_with_expire ) {
            /**
             * @var $package_with_expire Package
             */
            foreach ( $packages_with_expire as $package_with_expire ) {
                // Removing credits due to expire
                User::where( 'package_id', $package_with_expire->id )
                    ->where( 'credits_expire_date_at', '<', now() )
                    ->where( 'package_expires_at', '<', now() )
                    ->update( [ 'package_credits' => 0, 'package_id' => 0 ] );
                //charge credits for annual subscription
                User::where( 'package_id', $package_with_expire->id )
                    ->where( 'credits_expire_date_at', '<', now() )
                    ->where( 'package_expires_at', '>', now() )
                    ->update( [
                        'package_credits'        => $package_with_expire->credits,
                        'credits_expire_date_at' => now()->addMonths( $package_with_expire->credit_expiry )
                    ] );
            }
        }
    }
}
