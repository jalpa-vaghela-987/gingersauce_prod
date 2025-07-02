<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        $start = now()->addDays(-30)->startOfDay();
        $finish = now();

        $dates = $this->getDateRange();
        $users = $this->getSignedUsersByDate($start, $finish);
        $invoices = $this->getInvoicesByDate($start, $finish);
        $books = $this->getBooksByDate($start, $finish);

        $results = array_map(function($date) use ($users, $invoices, $books){
            return [
                'date' => $date,
                'users' => \Arr::get($users, $date),
                'invoices' => \Arr::get($invoices, $date),
                'books' => \Arr::get($books, $date),
            ];
        }, $dates);


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

    private function getDateRange($days = 30)
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
            count(*) as invoives,
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
        $data = \App\Brandbook::select('created_at', 'status', 'pdf_link', 'completed')
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

            if(\Arr::get($result[$date], $row['completed']) && $row['completed']){
                $result[$date][$row['completed']] += 1;
            }else{
                $result[$date][$row['completed']] = 1;
            }
        }

        return $result;
    }
}
