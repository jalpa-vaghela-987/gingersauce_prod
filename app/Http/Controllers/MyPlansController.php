<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MyPlansController extends Controller {
    public function index() {
        $user = \Auth::user();
        Log::info('Accessed plan index page', ['user_id' => $user->id]);

        $plan = null;

        if ($user->package) {
            Log::info('User has a package', ['user_id' => $user->id, 'package_id' => $user->package_id]);

            if ($user->package_expires_at) {
                $date = Carbon::parse($user->package_expires_at);
                $daysRemaining = Carbon::now()->diffInDays($date, false); // keep sign

                if ($daysRemaining < 0) {
                    $package_expiry = $date->format('F j, Y') . " (expired " . abs($daysRemaining) . " days ago)";
                } else {
                    $package_expiry = $date->format('F j, Y') . " (in {$daysRemaining} days)";
                }

                Log::info('Package has expiry date', [
                    'user_id' => $user->id,
                    'expires_at' => $user->package_expires_at,
                    'days_remaining' => $daysRemaining
                ]);
            } else {
                $package_expiry = '';
                Log::info('Package has no expiry date', ['user_id' => $user->id]);
            }

            $plan = [
                'title' => $user->package->title,
                'package_expiry' => $package_expiry,
                'amount' => $user->package->price,
                'books_remaining' => $user->credits() . '/' . $user->package->credits,
                'autorenewal' => $user->packageReccuringPayments()->exists(),
                'id' => $user->package_id
            ];

            Log::info('Compiled plan info', ['user_id' => $user->id, 'plan' => $plan]);
        } else {
            Log::info('User has no package', ['user_id' => $user->id]);
        }

        $books = $user->brandbooks()->public()->with('bookReccuringPayment')->get();
        Log::info('Retrieved public brandbooks for user', [
            'user_id' => $user->id,
            'book_count' => $books->count()
        ]);

        return view('profile.plans', ['plan' => $plan, 'books' => $books]);
    }
}
