<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BrandBookCreator\BrandBookHelper;

class StatsController extends Controller
{
    private $newSubscriptionsData = [];

    public function index()
    {
        $start = now()->addDays(-120)->startOfDay();
        $finish = now();

        $dates = $this->getDateRange();
        $users = $this->getSignedUsersByDate($start, $finish);
        $invoices = $this->getInvoicesByDate($start, $finish);
        $books = $this->getBooksByDate($start, $finish);
        $newSubscriptions = $this->getNewSubscriptionByDate($start, $finish);
        $existingSubscriptions = $this->getExistingSubscriptionByDate($start, $finish);
        logger(['from' =>'Stats controller', 'users'=> json_encode($users,true), 'invoices' => json_encode($invoices,true), 'books' => json_encode($books,true), 'new_subscriptions' => json_encode($newSubscriptions, true), 'existing_subscriptions' => json_encode($existingSubscriptions, true)]);

        $results = array_map(function($date) use ($users, $invoices, $books, $newSubscriptions, $existingSubscriptions){
            return [
                'date' => $date,
                'users' => \Arr::get($users, $date),
                'invoices' => \Arr::get($invoices, $date),
                'books' => \Arr::get($books, $date),
                'new_subscriptions' => \Arr::get($newSubscriptions, $date),
                'existing_subscriptions' => \Arr::get($existingSubscriptions, $date),
            ];
        }, $dates);

        logger(['from Stats controller',json_encode($results, true)]);

        return view('stats.index', compact('results'));
    }

    private function getSignedUsersByDate($start, $finish)
    {
        return \App\User::select(\DB::raw("DATE(created_at) as date, count(*) as users"))
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $finish)
            ->groupBy('date')
            ->pluck('users', 'date')
            ->toArray();
    }

    private function getDateRange($days = 120)
    {
        return array_map(function($day){
            return \Carbon\Carbon::now()->addDays(-1 * $day)->format('Y-m-d');
        },
        range(0, $days-1));
    }

    private function getInvoicesByDate($start, $finish)
    {
        $data = \App\Invoice::selectRaw("
            DATE(created_at) as date,
            count(*) as invoices,
            sum(price) as invoices_sum
            ")
            ->where('status', 'paid')
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $finish)
            ->groupBy('date')
            ->get()
            ->toArray();

        $result = [];

        foreach($data as $row){
            $result[$row['date']] = $row;
        }

        return $result;
    }

    private function getBooksByDate($start, $finish)
    {
        $data = \App\Brandbook::select('id', 'created_at', 'status', 'pdf_link', 'completed', 'version','bb_version')
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $finish)
            ->get();

        $result = [];

        foreach($data as $row){
            $date = $row->created_at->format('Y-m-d');
            if(!\Arr::get($result, $date)){
                $result[$date] = [];
            }

            if(
                \Arr::get($result[$date], $row['status'])
            ){
                $result[$date][$row['status']] += 1;
            }else{
                $result[$date][$row['status']] = 1;
            }

            if(
                $row['pdf_link'] &&
                json_decode($row['pdf_link'])
            ){
                if(\Arr::get($result[$date], 'pdf')){
                    $result[$date]['pdf'] += 1;
                }else{
                    $result[$date]['pdf'] = 1;
                }
            }

            //new number of completed books
            if(($row->bb_version == 2 || $row->bb_version == 3)  && $row->finished()) {
                if(\Arr::get($result[$date], 'pdf')){
                    $result[$date]['pdf'] += 1;
                }else{
                    $result[$date]['pdf'] = 1;
                }
            }

            if(\Arr::get($result[$date], $row['completed']) && $row['completed']){
                $result[$date][$row['completed']] += 1;
            }else{
                $result[$date][$row['completed']] = 1;
            }
        }

        return $result;
    }

    private function getNewSubscriptionByDate($start,   $finish) {
        $data = \App\Invoice::selectRaw("
            id, user_id, package_id,
            DATE(created_at) as date,
            count(*) as new_subscriptions")
            ->where('type', 'package')
            ->where('status', 'paid')
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $finish)
            ->having('new_subscriptions', '=', 1)
            ->groupBy(['user_id', 'package_id'])
            ->get()
            ->toArray();

        $this->newSubscriptionsData = $data;

        $result = [];

        foreach($data as $row){
            if(array_key_exists($row['date'], $result)) {
                $result[$row['date']]['new_subscriptions'] = $result[$row['date']]['new_subscriptions'] += $row['new_subscriptions'];
            } else {
                $result[$row['date']] = $row;
            }
        }

        return $result;
    }

    private function getExistingSubscriptionByDate($start, $finish) {
        $data = \App\Invoice::selectRaw("
            user_id, package_id,
            DATE(created_at) as date,
            count(*) as existing_subscriptions")
            ->where('type', 'package')
            ->where('status', 'paid')
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $finish)
            ->whereNotIn('id', array_column($this->newSubscriptionsData, 'id'))
            ->groupBy(['date', 'user_id', 'package_id'])
            ->get()
            ->toArray();

        $result = [];

        foreach($data as $row){
            if(array_key_exists($row['date'], $result)) {
                $result[$row['date']]['existing_subscriptions'] = $result[$row['date']]['existing_subscriptions'] += $row['existing_subscriptions'];
            } else {
                $result[$row['date']] = $row;
            }
        }

        return $result;
    }
}
