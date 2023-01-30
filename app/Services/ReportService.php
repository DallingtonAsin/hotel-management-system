<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class ReportService
{

    public function getMonthlyKitchenOrders()
    {
        return DB::select(
            'CALL monthly_kitchen_orders()'
        );
    }

    public static function getMonthlyKitchenOrdersData($status = null)
    {


        if($status){
            $result = DB::select("CALL monthly_kitchen_orders('".$status."')");
        }else{
            $result = DB::select('CALL monthly_kitchen_orders("")');
        }

        $months = $years = $orders = array();
        foreach ($result as $row) {
            array_push($months, date("F", mktime(0, 0, 0, $row->month_int, 10)));
            array_push($years, $row->year);
            array_push($orders, $row->total);
        }

        $data =['months' => $months, 'years' => $years, 'orders' => $orders];
        if (!empty($data)) {
            return $data;
        }
    }

    public static function getMonthlyPiechartKitchenOrdersData($status = null)
    {


        if($status){
            $result = DB::select("CALL monthly_kitchen_orders('".$status."')");
        }else{
            $result = DB::select('CALL monthly_kitchen_orders("")');
        }
          
        $data = [];
        $row = [];

        foreach($result as $item){
              $row['name'] = $item->month;
              $row['value'] = $item->total;
              array_push($data, $row);
        }
        
        if (!empty($data)) {
            return $data;
        }
    }


    
}