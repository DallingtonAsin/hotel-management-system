<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ReportService
{

    public function getMonthlyKitchenOrders()
    {
        return DB::select(
            'CALL monthly_kitchen_orders()'
        );
    }

    public function getMonthlyKitchenOrdersData($status = null)
    {


        if ($status) {
            $result = DB::select("CALL monthly_kitchen_orders('" . $status . "')");
        } else {
            $result = DB::select('CALL monthly_kitchen_orders("")');
        }

        $months = $years = $orders = array();
        foreach ($result as $row) {
            array_push($months, date("F", mktime(0, 0, 0, $row->month_int, 10)));
            array_push($years, $row->year);
            array_push($orders, $row->total);
        }

        $data = ['months' => $months, 'years' => $years, 'orders' => $orders];
        return $data;
    }

    public function getMonthlyPiechartKitchenOrdersData($status = null)
    {


        if ($status) {
            $result = DB::select("CALL monthly_kitchen_orders('" . $status . "')");
        } else {
            $result = DB::select('CALL monthly_kitchen_orders("")');
        }

        $data = [];
        $row = [];

        foreach ($result as $item) {
            $row['name'] = $item->month;
            $row['value'] = $item->total;
            array_push($data, $row);
        }

        return $data;
    }

    public function getMonthlyExpensesData()
    {
        $monthly_expenses = DB::select('CALL getMonthlyExpensesReport()');
        $months = $years = $expenses = [];

        foreach ($monthly_expenses as $row) {
            array_push($months, date("F", mktime(0, 0, 0, $row->month_int, 10)));
            array_push($years, $row->year);
            array_push($expenses, $row->total);
        }

        $data = ['months' => $months, 'years' => $years, 'expenses' => $expenses];
        return $data;
    }

    public function getMonthlyExpensesPieChartData()
    {
        $monthly_expenses = DB::select('CALL getMonthlyExpensesReport()');
        $data = [];
        $row = [];

        foreach ($monthly_expenses as $item) {
            $row['name'] = $item->month_name;
            $row['value'] = $item->total;
            array_push($data, $row);
        }
        return $data;
    }
}
