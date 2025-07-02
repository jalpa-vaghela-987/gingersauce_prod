<?php

namespace App\Http\Controllers;

use App\Brandbook;
use App\Console\Commands\RenewelSubscription;
use App\CreditLog;
use App\Tab;
use App\TabContent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;
use Exception;


class TestsController extends Controller
{
    public function getInfo()
    {
        // Retrieve PHP information
        $phpInfo = [
            'php_version' => phpversion(),
            'php_uname' => php_uname(),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'max_input_time' => ini_get('max_input_time'),
            'ICOUNT_USER' => env('ICOUNT_USER'),
            'ICOUNT_PASS' => env('ICOUNT_PASS'),
            'ICOUNT_CID' => env('ICOUNT_CID'),

            // Add more configuration values as needed
        ];
        return response()->json($phpInfo);
    }

    public function getUserSubscriptionDetail(User $user){

        return response()->json(['user' => $user, 'books'=> $user->brandbooks()->public()->with( 'bookReccuringPayment' )->get(),'brandbooks'=>$user->brandbooks()->get(),'package'=>$user->package,'detail'=> $user->packageReccuringPayments()]);
    }

    public function deleteEmptyTabAndTabContent($bookId, $slug) {
        $deleteTab = Tab::where('book_id', $bookId)->where('slug', $slug)->first();
        $deleteTab->is_deleted = 1;
        $deleteTab->save();
        TabContent::where('tab_id', $deleteTab->id)->delete();
    }

    public function getAllBrandBooks($limit){
        $allBook = Brandbook::select('id')->limit($limit)->orderBy('id', 'desc')->get();
        foreach($allBook as $book) {
            $bb = Brandbook::find($book->id);
            if(!$bb->vision && !$bb->vision_text) {
                $this->deleteEmptyTabAndTabContent($bb->id, 'vision');
            }

            if(!$bb->mission && !$bb->mission_text) {
                $this->deleteEmptyTabAndTabContent($bb->id, 'mission');
            }

            if(count(json_decode($bb->core_values), true) == 0) {
                $this->deleteEmptyTabAndTabContent($bb->id, 'core-values');
            }

            if(count($bb->voices) == 0) {
                $this->deleteEmptyTabAndTabContent($bb->id, 'brand-archetype');
            }

            if(count(json_decode($bb->missuses), true) == 0) {
                $this->deleteEmptyTabAndTabContent($bb->id, 'logo-misuse');
            }

            if(count(json_decode($bb->icon_family), true) == 0) {
                $this->deleteEmptyTabAndTabContent($bb->id, 'feature-icons');
            }
        }
        $users = User::select('id', 'name')->limit($limit)->orderBy('id', 'desc')->get();
        return response()->json(['books' => $allBook, 'users' => $users]);
    }

    public function getCreditsLog($date, $userId = null) {
         if($userId != null) {
            $logs = CreditLog::where('user_id', $userId)->orderBy('id', 'desc')->get();
        } else if($date == 'all') {
            $logs = CreditLog::where('invoice_id', '!=', null)->where('type', 'book extend')->orderBy('id', 'desc')->get();
        } else {
            $logs = CreditLog::where('invoice_id', '!=', null)->where('type', 'book extend')->where('created_at', '>=', $date)->orderBy('id', 'desc')->get();
        }
        return response()->json(['logs' => $logs]);
    }

    public function getRecurringBooks($limit = null) {
        $brandbooks = Brandbook::select(['id', 'brand', 'expires_at', 'status', 'recurring_id', 'user_id'])->where('recurring_id', '!=', null)->get();
        return response()->json(['brandbooks' => $brandbooks]);
    }

    public function updateExpiryDate($bookId, $date) {
        Brandbook::where('id', $bookId)
            ->update([
               'expires_at' => $date
            ]);
        $brandbook = Brandbook::find($bookId);
        return response()->json(['brandbook' => $brandbook]);
    }

    public function getAutoRenewwalOnBooks() {
        $books =  Brandbook::select(['id', 'brand', 'expires_at', 'status', 'recurring_id', 'user_id'])
//            ->where('status', 'public')
//            ->whereHas("user.paymentDefault")
            ->whereHas("lastInvoice")
            ->orWhereHas("watermarkLastInvoice")
            ->get();
        return response()->json(['brandbook' => $books]);
    }

    public function runAutoRenewwalCommand() {
        $auto = new RenewelSubscription();
        $auto->handle();
        //laravel-2024-07-23
        return (storage_path('logs/' . 'laravel-'.date("Y") . '-' . date("m") . '-' . date("d") . '.log')) ?? 'none';
    }

    public function readTodayLogFile() {
        $file = storage_path('logs/' . 'laravel-'.date("Y") . '-' . date("m") . '-' . date("d") . '.log');
        $myfile = fopen($file, "r") or die("Unable to open file!");
        echo fread($myfile, filesize($file));
        fclose($myfile);
    }

    public function testFiles($id=null) {
        $file = storage_path('logs/laravel.log');
        file_put_contents($file, 'Test log entry');
        echo 'Log written to ' . $file;
        die;
        $imagick = new \Imagick();
        $formats = $imagick->queryFormats();
        print_r($formats);

        $brandbook = Brandbook::find($id);
        echo "logo start......";
        echo $image = $brandbook->logo;
        echo "logo end......";
        $path = "bbassets/$id/logos/logo";
        $file = storage_path( $path . '.svg' );
        Image::configure( [ 'driver' => 'imagick' ] );
        echo $file;

        //$image = str_replace(' viewBox', ' transform="scale(0.2)" viewBox', $image); you easy can change image size by transform
        file_put_contents( $file, $image );
//        print_r($file);
//        die;
//        $img      = Image::make( $file ); //this is SVG
//        $file_png = str_replace( '.svg', '.png', $file );
//        exec( 'rsvg-convert ' . $file . ' -o ' . $file_png );
//        $img_px = Image::make( $file_png );
//        print_r($img);


        echo "<br>";
        echo "<br>";

        try {
            $img = Image::make($file); // or any other image path
            echo "img.... found testing.....";
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
            // Handle the error or log it
            echo 'Error: ' . $e->getMessage();
        }

        echo "<br>";
        echo "<br>";


        // Define the folder path
        $folderPath = storage_path('app/public/bbassets/');

        // Check if folder exists
        if (!File::exists($folderPath)) {
           echo "app public bbassets Folder does not exist.". $folderPath."<br/>";
        } else {
            echo "bbassets Folder exist.". $folderPath."<br/>";
            $this->getFolderPaths($folderPath);
        }

        $folderPath2 = storage_path('bbassets-admin/');
        if (!File::exists($folderPath2)) {
            echo " bbassets Folder does not exist.". $folderPath2."<br/>";
        } else {
            echo " bbassets Folder exist.". $folderPath2."<br/>";

//            $this->getFolderPaths($folderPath2);
            // Check if the directory is readable
            if (!is_readable($folderPath2)) {
                echo "Directory is not readable<br/>";
            } else {
                echo "Directory is readable<br/>";
            }

            // Check if the directory is writable
            if (!is_writable($folderPath2)) {
                echo "Directory is not writable<br/>";
            } else {
                echo "Directory is writable<br/>";
            }

            // Check if the directory is executable (required to open directories and read file names)
            if (!is_executable($folderPath2)) {
                echo "Directory is not executable<br/>";
            } else {
                echo "Directory is executable<br/>";
            }

            $this->getFolderPaths($folderPath2);
        }


        $folderPath3 = storage_path('app/bbassets/');
        if (!File::exists($folderPath3)) {
            echo " bbassets Folder does not exist.". $folderPath3."<br/>";
        } else {
            echo " bbassets Folder exist.". $folderPath3."<br/>";
            $this->getFolderPaths($folderPath3);
        }

        if($id) {
            $brandbook = Brandbook::find($id);
            print_r($brandbook);
        }
    }

    public function getFolderPaths($folderPath){
        // Get files and subdirectories
        $files = File::allFiles($folderPath);
        $fileList = [];

        // Loop through files to get relative paths
        foreach ($files as $file) {
            $fileList[] = [
                'file_name' => $file->getRelativePathname(),
                'file_size' => $file->getSize(),
                'last_modified' => date('Y-m-d H:i:s', $file->getMTime())
            ];
        }

        print_r($fileList);
    }

    public function testSMTP(Request $request)
    {
        $toEmail = $request->input('email', config('mail.from.address'));

        try {
            Mail::raw('This is a test email for SMTP configuration.', function ($message) use ($toEmail) {
                $message->to($toEmail)
                        ->subject('SMTP Test Email');
            });

            return response()->json(['success' => true, 'message' => '✅ SMTP connection successful. Email sent.']);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ SMTP Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
