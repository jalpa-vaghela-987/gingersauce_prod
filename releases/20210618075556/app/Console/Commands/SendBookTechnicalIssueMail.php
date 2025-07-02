<?php

namespace App\Console\Commands;

use App\Brandbook;
use Mail;
use File;
use App\Mail\BookTechnicalIssueMail;
use Illuminate\Console\Command;

class SendBookTechnicalIssueMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send-book-technical-issue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to users that technical-issue with books was fixed';

    protected $maillistFile;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->maillistFile = database_path('maillist.txt');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $books = Brandbook::where('created_at', '>', '2021-12-01')
            ->with('user')
            ->groupBy('user_id')
            ->where('completed', '>', 24)
            ->get();

        console . log();

        foreach ($books as $book) {

            if (in_array($book->user->email, $this->getMailList())) {
                continue;
            }
            echo PHP_EOL . $book->user->email;

            File::append($this->maillistFile, PHP_EOL . $book->user->email);

            Mail::to($book->user->email)
                ->bcc(config('mail.bcc'))
                ->send((new BookTechnicalIssueMail($book)));
        }

        echo PHP_EOL . "Done";
    }

    private function getMailList()
    {
        return file($this->maillistFile, FILE_IGNORE_NEW_LINES);
    }
}
