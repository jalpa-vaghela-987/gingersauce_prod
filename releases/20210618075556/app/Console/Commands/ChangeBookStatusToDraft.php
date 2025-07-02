<?php

namespace App\Console\Commands;

use DB;
use App\Brandbook;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ChangeBookStatusToDraft extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:makedraft';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change expired book status to draft';

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
    public function handle()
    {
        $expiry = Carbon::now('Asia/Jerusalem')->addDay()->setTime(7, 0, 0);
        $books = $this->ExpiringBooksCriteria($expiry)->get();

        $this->ExpiringBooksCriteria($expiry)->update([
            'status' => 'draft',
            'expires_at' => $expiry->addWeeks(2),
        ]);

        $books->each(function ($book){
            $book->bookReccuringPayment()->delete();
        });

    }

    private function ExpiringBooksCriteria($expiry)
    {
        return Brandbook::withTrashed()
            ->leftJoin('books_reccuring_payments', 'books_reccuring_payments.book_id', '=', 'brandbooks.id')
            ->where('expires_at', '<', $expiry)
            ->whereNotNull('user_id')
            ->whereNotNull('book_id')
            ->select(DB::raw('brandbooks.*, books_reccuring_payments.id AS books_reccuring_payments_id'))
            ->where('status', 'public');
    }
}
