<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\ErrorLog;
use App\Models\Stock;
use App\Models\Purchase;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Http\Controllers\LogsController;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessSendSms;
use App\User;
use Constant;

class Helper
{
    
    public static function logError($data){
        
        try{
            $username = $data['username'];
            $error_code = $data['error_code'];
            $error_message = $data['error_message'];
            $error_severity = $data['error_severity'];
            $controller = $data['controller'];
            $method = $data['method'];

            $error = new ErrorLog();
            $error->username = $username;
            $error->error_code = $error_code;
            $error->error_message = $error_message;
            $error->error_severity = $error_severity;
            $error->controller = $controller;
            $error->method = $method;

            $resp = $error->save();

        }catch(\Exception $ex){

        }
    }

    public static function GetItemName($stockId){
        try{

            $item = Stock::where('id', $stockId)->value('item');
            return $item;

        }catch(\Exception $ex){
            dd($ex->getMessage());
        }
    }

    public static function Numberize($input){
        try{
            $result = floatval(preg_replace('/[^\d.]/','', $input));
            return $result;
        }catch(\Exception $ex){
            dd($ex->getMessage());
        }
    }

     public static function getRoleId($role){
      try{
        $roleId = Role::where('role', 'like', '%'.$role.'%')->value('role_id');
        return $roleId;
      }catch(\Exception $ex){
        dd($ex->getMessage());
      }
    }

     public static function getRole($roleId){
      try{
        $role = Role::where('role_id', $roleId)->value('role');
        return $role;
      }catch(\Exception $ex){
        dd($ex->getMessage());
      }
    }

    public static function getRoles(){
        try{
            $roles = Role::get();
            return $roles;
        }catch(\Exception $ex){
            dd($ex->getMessage());
        }
    }
    
    
    public static function SendTextMessage(Request $request, $to, $text_message){
        $from = config('app.name');
        try{
            $arr = array(
                   'from' => $from,
                   'to' => $to,
                   'message' => $text_message,
                   'created_at' => now(),
            );
        //put a method to log this request before API call
         Helper::EnqueueSms($arr); // $this->SendTextMessage($from, $to, $text_message);
	//	Log::info('app.requests', ['request' => $request->all(), 'response' => $response]);

   // if($res){
        $action = "sent a text message to ".$to."";
        //Log this transactional request
        LogsController::logger($request, $action, now());

        return 1;
    // }
    // else{
    //     return back()->with("fail", "Sorry, message has not been sent!");

    // }
}catch(Exception $ex){
    echo('Problems thhh');
    return back()->with("fail", "Sorry, message has not been sent!");
}
}

    protected static function EnqueueSms($data)
    {
        dispatch(new ProcessSendSms($data))->onQueue('sms');
      
    }

    public static function createOrUpdatePurchase($row){
        
        try{

         $id = $row['id'];
         if(isset($id)){

           $purchaseArr = [
          'serial_no' => $row['sno'],
          'receipt_no' => $row['receipt_no'],
          'item_id' => $row['item_id'],
          'item' => $row['item'],
          'quantity' => Helper::Numberize($row['qty']),
          'cost_price_per_item' => Helper::Numberize($row['price_per_item']),
          'retail_price' => Helper::Numberize($row['retail_price']),
          'wholesale_price' => Helper::Numberize($row['wholesale_price']),
          'supplier' => $row['supplier'],
          'supplier_contact' => $row['suppliers_contact'],
          'recorded_by' => Auth::user()->name,
          'date_of_purchase' =>  $row['date_of_purchase'],
          ];

           Purchase::where('id', $id)
           ->update($purchaseArr);

         }else{

          $purchase = new Purchase();
          $purchase->serial_no = $row['sno'];
          $purchase->receipt_no = $row['receipt_no'];
          $purchase->item_id = $row['item_id'];
          $purchase->item = $row['item'];
          $purchase->quantity = Helper::Numberize($row['qty']);
          $purchase->cost_price_per_item = Helper::Numberize($row['price_per_item']);
          $purchase->retail_price = Helper::Numberize($row['retail_price']);
          $purchase->wholesale_price = Helper::Numberize($row['wholesale_price']);
          $purchase->supplier = $row['supplier'];
          $purchase->supplier_contact = $row['suppliers_contact'];
          $purchase->recorded_by = Auth::user()->name;
          $purchase->date_of_purchase = $row['date_of_purchase'];
          $purchase->save();
    
         }
        return true;
        }catch(Exception $ex){
              dd($ex->getMessage());
           }
      
         }


 public static function createStock($row){
     try{
         $insertStock =  Stock::create([
          'item_id' => $row['item_id'],
          'item' => $row['item'],
          'quantity' => floatval(Helper::Numberize($row['qty'])),
          'buying_price' => floatval(Helper::Numberize($row['price_per_item'])),
          'selling_price' => floatval(Helper::Numberize($row['retail_price'])),
          'wholesale_price' => floatval(Helper::Numberize($row['wholesale_price'])),
          'supplier' => $row['supplier']
        ]);
        return true;
      }catch(Exception $ex){
              dd($ex->getMessage());
           }
}


 public static function getStock()
    {
      $items = Stock::all();
      $itemsArr = array();
      foreach ($items as $item) {
        array_push($itemsArr, $item->item);
      }
      return $itemsArr;
    }

 public static function getItemQty($item)
    {
      $qty = Stock::where('item', $item)
             ->value('quantity');
      return $qty;
}

public static function isItemInStock($item){
    try{
       $stock = Helper::getStock();
       in_array($item, $stock) ? $res = true : $res = false;
       return $res;
    }catch(\Exception $ex){
        dd($ex->getMessage());
    }
}


  public static function getUserRoleId($role)
    {
        try {
            $roleId = Role::where('role', 'like', '%'.$role.'%')
                     ->value('role_id');
            return $roleId;
        } catch (\Exception $ex) {
            $data = array(
                'username' => auth()->user()->username,
                'error_code' => $ex->getCode(),
                'error_message' => $ex->getMessage(),
                'error_severity' => Constant::$STATUS_ERROR_SEVERITY,
                'controller' => 'Helper',
                'method' => 'getRole'
            );
            Helper::logError($data);
            abort(409, $ex->getMessage());
        }
    }


 public static function GetUserStats($role)
    {
        try {
            $role_id = Helper::getUserRoleId($role);
            $users_list = User::where('user_role', $role_id)->get();
            $number_of_users = User::where('user_role', $role_id)->count();
            $data = array(
                    'totl' => $number_of_users,
                    'list' => $users_list
                    );

            return $data;
        } catch (\Exception $ex) {
            $data = array(
          'username' => auth()->user()->username,
          'error_code' => $ex->getCode(),
          'error_message' => $ex->getMessage(),
          'error_severity' => Constant::$STATUS_ERROR_SEVERITY,
          'controller' => 'Helper',
          'method' => 'GetUserStats'
      );
            Helper::logError($data);
            abort(409, $ex->getMessage());
        }
    }

    public static function getMonthlySalesData()
    {
      $year = date('Y');
      $result = DB::table('monthlysales')
                 ->where('SalesYear', $year)
                 ->orderBy('month_int','asc')
                ->get();
      $max_sale_value = DB::table('monthlysales')->max('TotalSales');
      $data = $months = $years = $sales = array();
      foreach($result as $row){
        array_push($months, date("F", mktime(0, 0, 0, $row->month_int, 10)));
        array_push($years, $row->SalesYear);
        array_push($sales, $row->TotalSales);
      }
      $data = array('months' => $months,'years' => $years, 'sales' => $sales,'max' => $max_sale_value);
      if(!empty($data))
      {
        return $data;
      }

    }

    public static function convertNumber($number){
        Helper::is_decimal($number)
        ? $number = number_format($number, 2) 
        : $number =  number_format($number);
        return $number;
    }

    public static function is_decimal($n) {
       return is_numeric($n) && floor($n) != $n;
    }


}
