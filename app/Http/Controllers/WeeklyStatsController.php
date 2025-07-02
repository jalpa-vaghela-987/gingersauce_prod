<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\BrandBookCreator\BrandBookHelper;

class WeeklyStatsController extends Controller
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

        $results = array_map(function ($date) use ($users, $invoices, $books, $newSubscriptions, $existingSubscriptions) {
            $weekUsers = 0;
            $weekInvoices = [];
            $weekBooks = [];
            $weekNewSubscriptions = [];
            $weekExistingSubscriptions = [];

            for ($i = 0; $i < 7; $i++) {
                $newDate = Carbon::parse($date)->subDays($i)->format('Y-m-d');
                if (\Arr::get($users, $newDate)) {
                    $weekUsers = $weekUsers + \Arr::get($users, $newDate);
                }
                if (\Arr::get($invoices, $newDate)) {
                    $invoice = \Arr::get($invoices, $newDate);
                    if (\Arr::get($invoice, 'invoices')) {
                        $weekInvoices['invoices'] = data_get($weekInvoices, 'invoices', 0) + \Arr::get($invoice, 'invoices');
                    }
                    if (\Arr::get($invoice, 'invoices_sum')) {
                        $weekInvoices['invoices_sum'] = data_get($weekInvoices, 'invoices_sum', 0) + \Arr::get($invoice, 'invoices_sum');
                    }
                }
                if (\Arr::get($books, $newDate)) {
                    $record = \Arr::get($books, $newDate);
                    if (\Arr::get($record, 'draft')) {
                        $weekBooks['draft'] = data_get($weekBooks, 'draft', 0) + \Arr::get($record, 'draft');
                    }
                    if (\Arr::get($record, 'public')) {
                        $weekBooks['public'] = data_get($weekBooks, 'public', 0) + \Arr::get($record, 'public');
                    }
                    if (\Arr::get($record, 'pdf')) {
                        $weekBooks['pdf'] = data_get($weekBooks, 'pdf', 0) + \Arr::get($record, 'pdf');
                    }

                    $steps = \Arr::get($books, $newDate);
                    if (data_get($steps, 'public')) {
                        unset($steps['public']);
                    }
                    if (data_get($steps, 'draft')) {
                        unset($steps['draft']);
                    }
                    if (data_get($steps, 'pdf')) {
                        unset($steps['pdf']);
                    }

                    foreach (array_keys($steps) as $step) {
                        if ($step && data_get($weekBooks, 'count')) {
                            //logger("from if $step , $newDate");
                            if (in_array($step, array_keys(data_get($weekBooks, 'count')))) {
                                //logger("from if of if $step , $newDate");

                                $weekBooks['count'][$step] = $weekBooks['count'][$step] + $steps[$step];
                                unset($steps[$step]);
                            } else {
                                //logger(["from else of if $step", $newDate, $weekBooks['count']]);
                                $weekBooks['count'][$step] = $steps[$step];
                            }
                        } else {
                            //logger(["from else $step", $newDate, data_get($weekBooks, 'count')]);
                            if (data_get($weekBooks, 'count')) {
                                //logger("from if of else $step , $newDate");
                                $weekBooks['count'][$step] = $steps[$step];
                            } else {
                                //logger("from else of else $step , $newDate");
                                $weekBooks['count'] = $steps;
                            }
                        }
                    }
                }

                if (\Arr::get($newSubscriptions, $newDate)) {
                    $newSubscription = \Arr::get($newSubscriptions, $newDate);
                    if (\Arr::get($newSubscription, 'new_subscriptions')) {
                        $weekNewSubscriptions['new_subscriptions'] = data_get($weekNewSubscriptions, 'new_subscriptions', 0) + \Arr::get($newSubscription, 'new_subscriptions');
                    }
                }

                if (\Arr::get($existingSubscriptions, $newDate)) {
                    $existingSubscription = \Arr::get($existingSubscriptions, $newDate);
                    if (\Arr::get($existingSubscription, 'existing_subscriptions')) {
                        $weekExistingSubscriptions['existing_subscriptions'] = data_get($weekExistingSubscriptions, 'existing_subscriptions', 0) + \Arr::get($existingSubscription, 'existing_subscriptions');
                    }
                }
            }

            return [
                'date' => $date,
                'users' => $weekUsers,
                'invoices' => $weekInvoices,
                'books' => $weekBooks,
                'new_subscriptions' => $weekNewSubscriptions,
                'existing_subscriptions' => $weekExistingSubscriptions
            ];
        }, $dates);

        logger(json_encode($results, true));

        return view('stats.weekly.index', compact('results'));
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
        return array_map(function ($day) {
            return \Carbon\Carbon::now()->addDays(-7 * $day)->format('Y-m-d');
        },
            range(0, $days - 7));
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

        foreach ($data as $row) {
            $result[$row['date']] = $row;
        }

        return $result;
    }

    private function getBooksByDate($start, $finish)
    {
        $data = \App\Brandbook::select('id', 'created_at', 'status', 'pdf_link', 'completed', 'version', 'bb_version')
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $finish)
            ->get();

        $result = [];

        foreach ($data as $row) {
            $date = $row->created_at->format('Y-m-d');
            if (!\Arr::get($result, $date)) {
                $result[$date] = [];
            }

            if (
            \Arr::get($result[$date], $row['status'])
            ) {
                $result[$date][$row['status']] += 1;
            } else {
                $result[$date][$row['status']] = 1;
            }

            if (
                $row['pdf_link'] &&
                json_decode($row['pdf_link'])
            ) {
                if (\Arr::get($result[$date], 'pdf')) {
                    $result[$date]['pdf'] += 1;
                } else {
                    $result[$date]['pdf'] = 1;
                }
            }

            //new => count number of completed books
            if(($row->bb_version == 2 || $row->bb_version == 3) && $row->finished()) {
                if(\Arr::get($result[$date], 'pdf')){
                    $result[$date]['pdf'] += 1;
                }else{
                    $result[$date]['pdf'] = 1;
                }
            }

            if (\Arr::get($result[$date], $row['completed']) && $row['completed']) {
                $result[$date][$row['completed']] += 1;
            } else {
                $result[$date][$row['completed']] = 1;
            }
        }

        return $result;
    }

    private function getNewSubscriptionByDate($start, $finish) {
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
