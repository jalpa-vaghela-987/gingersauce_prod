<?php

namespace App\Console\Commands;

use App\Brandbook;
use App\Mail\BookDeleteReminder;
use App\Services\PaymentSystem\ICount;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RenewelSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renew:subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renew Subscription for users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $now =   Carbon::now( 'Asia/Jerusalem' );
        $books =  Brandbook::select(['id', 'brand', 'expires_at', 'status', 'recurring_id', 'user_id'])
//            ->where('status', 'public')
            ->whereHas("user.paymentDefault")
            ->whereHas("lastInvoice")
            ->orWhereHas("watermarkLastInvoice")
            ->get();

        $ICount = new ICount();
        foreach ($books as $key => $book) {
            if ( $book && ($book->lastInvoice->count() > 0 || $book->watermarkLastInvoice->count() > 0)) {
                if($book->status == "draft" && $now->diffInMonths(Carbon::parse($book->created_at)) >= 3){
                    Log::info("email sending user", $book->id, $book->user->email);
                    Mail::to( $book->user->email )->send( new BookDeleteReminder( $book ) );
                }else{
                    //check if recurring is active
                    $isRecurringActive  =   $book->bookReccuringPayment()->exists();
                    //check if recurring is active ends
                    if($isRecurringActive && $book->recurring_id == null){
                        if ($book->expires_at < $now) {
                            $bookOwner      =   $book->user;
                            $cc_stored      =   $book->user->paymentDefault()->first();
                            $card_ifo = $ICount->getTokenInfo( [
                                "client_id" =>  $cc_stored->client_id,
                                "custom_client_id"  =>  $cc_stored->custom_client_id,
                                "email" =>  $bookOwner->email,
                                "client_name"   =>  $bookOwner->name,
                                "cc_token_id"   =>  $cc_stored->token_id
                            ]);
                            if($card_ifo["status"]){
                                $lastInvoice = ($book->lastInvoice->first()) ?? $book->watermarkLastInvoice->first();
                                $data   =   [
                                    "client_id" =>  $card_ifo['client_id'],
                                    "custom_client_id"  =>  $card_ifo['custom_client_id'],
                                    "email" =>  $bookOwner->email,
                                    "client_name"   =>  $bookOwner->name,
                                    "cc_token_id"   =>  $card_ifo['cc_token_id'],
                                    "cc_number" =>  $card_ifo['cc_number'],
                                    "cc_validity"   =>  $card_ifo['cc_exp_year']. '-' . $card_ifo['cc_exp_month'],
                                    "cc_holder_name"=> $card_ifo['cc_holder_name'],
                                    "cc_holder_id"=> $bookOwner->id,
                                    "start_date"=> Carbon::now( 'Asia/Jerusalem' )->format("Y-m-d"),
                                    "num_of_payments"=> 0,
                                    "issue_every"=> 12,
                                    "currency" => 'USD',
                                    "items" =>  [
                                        [
                                            "item_id"=>$book->id,
                                            "inventory_item_id"=>$book->id,
                                            "description"=>$book->brand,
                                            "long_description"=>$book->brand,
                                            "unitprice"=>$lastInvoice->price,
                                            "quantity"=>1,
                                        ]
                                    ],
                                    "price_indexing"=>[
                                        "type"=> "USD",
                                        "adjustment"=> "base",
                                    ],
                                    "email_to_client"=> true,
                                    "email_cc"=> $bookOwner->email,
                                    "email_client_on_issue"=> true,
                                    "lang"=> config( 'app.locale' ),
                                ];
                                $recurring  =   $ICount->enableAutoRenewel($data);
                                if($recurring["status"]==true){
                                    //update recurring id in db
                                    $book->recurring_id = $recurring['hk_id'];
                                    $book->save();
//
                                    Log::info("Recurring is active for id:".$book->id);
                                }else{
                                    Log::info("payment recurring failed for book with id:".$book->id.", Reason:".$recurring["reason"]);
                                }
                            }else{
                                Log::info("Credit card not found");
                            }
                        }else{
                            Log::info("not Expire yet");
                        }

                    } else if($book->recurring_id != null) {
                        $data = [
                            'hk_id' => $book->recurring_id
                        ];
                        $info = $ICount->getRecurringInfo($data);
                        Log::info('info', $info);
                        if(!$isRecurringActive && $info['hk_info']['is_paused'] != 1) {
                            $pauseAutoRenewel = $ICount->pauseAutoRenewel($data);
                            Log::info('pause', $pauseAutoRenewel);
                            if($pauseAutoRenewel['status'] == true) {
                                Log::info("Recurring is pause book id ".$book->id);
                            }
                        } else if($isRecurringActive && $info['hk_info']['is_paused'] == 1) {
                            $resumeAutoRenewel = $ICount->resumeAutoRenewel($data);
                            Log::info('resume', $resumeAutoRenewel);
                            if ($resumeAutoRenewel['status'] == true) {
                                Log::info("Recurring is resume book id " . $book->id);
                            }
                        } else {
                            Log::info("Nothing to recurring");
                        }
                    } else{
                        Log::info("Recurring is already active");
                    }
                }
            }
        }
    }
}
