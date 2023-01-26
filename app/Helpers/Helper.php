<?php

namespace App\Helpers;

use App\Models\Designation;
use App\Models\KitchenMenuItem;
use Illuminate\Http\Request;
use App\Models\ErrorLog;
use App\Models\Stock;
use App\Models\Purchase;
use App\Models\Department;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\Damage;
use App\Models\Supplier;
use App\Models\Room;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessSendSms;
use App\Staff;
use App\Helpers\Constants as Constant;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\RequestResponse;
use Illuminate\Support\Facades\Mail;
use App\Models\Logs;


class Helper
{


  public static function getUserNames($id)
  {
    try {

      $user = Staff::find($id);
      return $user->first_name . ' ' . $user->last_name;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }
  public static function logError($data)
  {

    try {
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
    } catch (\Exception $ex) {
    }
  }

  public static function getRandomValue($arr)
  {
      $random_key = array_rand($arr);
      $random_value = $arr[$random_key];
      return $random_value;
  }

  public static function GetItemName($stockId)
  {
    try {

      $item = Stock::where('id', $stockId)->value('item');
      return $item;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function Numberize($input)
  {
    try {
      $result = floatval(preg_replace('/[^\d.]/', '', $input));
      return $result;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function getDepartmentId($role)
  {
    try {
      $departmentId = Department::where('role', 'like', '%' . $role . '%')->value('id');
      return $departmentId;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function getDepartment($departmentId)
  {
    try {
      $department = Department::where('id', $departmentId)->value('name');
      return $department;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function getDesignation($designationId)
  {
    try {
      $designation = Designation::where('id', $designationId)->value('name');
      return $designation;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function getDepartments()
  {
    try {
      $roles = Department::get();
      return $roles;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }


  public static function SendTextMessage(Request $request, $to, $text_message)
  {
    $from = config('app.name');
    try {
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
      $action = "sent a text message to " . $to . "";
      //Log this transactional request
      Helper::logger($request, $action, now());

      return 1;
      // }
      // else{
      //     return back()->with("fail", "Sorry, message has not been sent!");

      // }
    } catch (\Exception $ex) {
      echo ('Problems thhh');
      return back()->with("fail", "Sorry, message has not been sent!");
    }
  }

  protected static function EnqueueSms($data)
  {
    dispatch(new ProcessSendSms($data))->onQueue('sms');
  }


  public static function insertPurchaseAndUpdateStock($row)
  {

    try {
      //  dd($row);
      if (Helper::array_key_isset('selling_price', $row)) {
        $sellingPrice = Helper::Numberize($row['selling_price']);
      } else {
        $sellingPrice = Helper::array_key_isset('retail_price', $row) ? Helper::Numberize($row['retail_price']) : null;
      }

      if (Helper::array_key_isset('quantity', $row)) {
        $quantity = Helper::Numberize($row['quantity']);
      } else {
        $quantity = Helper::array_key_isset('qty', $row) ? Helper::Numberize($row['qty']) : null;
      }

      $purchase = new Purchase();
      $purchase->serial_no = Helper::array_key_isset('sno', $row) ? $row['sno'] : null;
      $purchase->receipt_no = Helper::array_key_isset('receipt_no', $row) ? $row['receipt_no'] : null;
      $purchase->item_code = $row['item_code'];
      $purchase->item = $row['item'];
      $purchase->quantity = $quantity;
      $purchase->cost_price_per_item = Helper::Numberize($row['buying_price']);
      $purchase->retail_price = $sellingPrice;
      $purchase->wholesale_price = Helper::array_key_isset('wholesale_price', $row) ? Helper::Numberize($row['wholesale_price']) : null;
      $purchase->supplier = Helper::array_key_isset('supplier', $row) ? $row['supplier'] : null;
      $purchase->supplier_contact = Helper::array_key_isset('suppliers_contact', $row) ? $row['suppliers_contact'] : null;
      $purchase->created_by = Auth::user()->name;
      $purchase->date_of_purchase = Helper::array_key_isset('date_of_purchase', $row) ? $row['date_of_purchase'] : date('Y-m-d');

      $isSaved = $purchase->save();
      if ($isSaved) {
        Helper::insertOrUpdateStock($row);
      } else {
        dd("What is not right?");
      }
      return true;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function insertOrUpdateStock($row)
  {

    try {

      $item_code = $row['item_code'];
      $category = Helper::array_key_isset('category', $row) ? $row['category'] : null;
      $supplier = Helper::array_key_isset('supplier', $row) ? $row['supplier'] : null;
      $thresholdQty = Helper::array_key_isset('thresholdQty', $row) ? Helper::Numberize($row['thresholdQty']) : null;
      $expiryDate = Helper::array_key_isset('expiry_date', $row) ? $row['expiry_date'] : null;
      $wholeSalePrice = Helper::array_key_isset('wholesale_price', $row) ? Helper::Numberize($row['wholesale_price']) : null;

      if (Helper::array_key_isset('selling_price', $row)) {
        $sellingPrice = Helper::Numberize($row['selling_price']);
      } else {
        $sellingPrice = Helper::array_key_isset('retail_price', $row) ? Helper::Numberize($row['retail_price']) : null;
      }

      if (Helper::array_key_isset('quantity', $row)) {
        $quantity = Helper::Numberize($row['quantity']);
      } else {
        $quantity = Helper::array_key_isset('qty', $row) ? Helper::Numberize($row['qty']) : null;
      }

      $findStock = Stock::where('item_code', $item_code);
      if (isset($item_code) && $findStock->exists()) {

        $newQuantity = Helper::Numberize($findStock->value('quantity')) + $quantity;
        $stock = [
          'item_code' => $item_code,
          'item' => $row['item'],
          'category' => $category,
          'supplier' => $supplier,
          'quantity' => $newQuantity,
          'threshold_qty' => $thresholdQty,
          'expiry_date' => $expiryDate,
          'buying_price' => $row['buying_price'],
          'selling_price' => $sellingPrice,
          'wholesale_price' => $wholeSalePrice
        ];

        Stock::where('item_code', $item_code)
          ->update($stock);
      } else {

        $stock = new Stock();

        $stock->item_code = $item_code;
        $stock->item = $row['item'];
        $stock->category = $category;
        $stock->supplier = $supplier;
        $stock->quantity = $quantity;
        $stock->threshold_qty = $thresholdQty;
        $stock->expiry_date = $expiryDate;
        $stock->buying_price = $row['buying_price'];
        $stock->selling_price = $sellingPrice;
        $stock->wholesale_price = $wholeSalePrice;
        $stock->save();
      }
      return true;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  private static function array_key_isset($k, $a)
  {
    return isset($a[$k]); // || array_key_exists($k, $a);
  }


  public static function createStock($row)
  {
    try {
      $insertStock = Stock::create([
        'item_code' => $row['item_code'],
        'item' => $row['item'],
        'quantity' => floatval(Helper::Numberize($row['qty'])),
        'buying_price' => floatval(Helper::Numberize($row['price_per_item'])),
        'selling_price' => floatval(Helper::Numberize($row['retail_price'])),
        'wholesale_price' => floatval(Helper::Numberize($row['wholesale_price'])),
        'supplier' => $row['supplier']
      ]);
      return true;
    } catch (\Exception $ex) {
      throw $ex;
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

  public static function isItemInStock($item)
  {
    try {

      $stock = Helper::getStock();
      return in_array($item, $stock);
    } catch (\Exception $ex) {
      throw $ex;
    }
  }


  public static function getUserDepartmentId($role)
  {
    try {
      $departmentId = Department::where('role', 'like', '%' . $role . '%')
        ->value('id');
      return $departmentId;
    } catch (\Exception $ex) {
      $data = array(
        'username' => auth()->user()->username,
        'error_code' => $ex->getCode(),
        'error_message' => $ex->getMessage(),
        'error_severity' => Constant::$STATUS_ERROR_SEVERITY,
        'controller' => 'Helper',
        'method' => 'getDepartment'
      );
      Helper::logError($data);
      abort(409, $ex->getMessage());
    }
  }


  public static function GetUserStats()
  {
    try {

      $staff = Staff::all();
      $total_staff = Staff::where('is_deleted', false)->count();
      $data = array(
        'list' => $staff,
        'totl' => $total_staff
      );

      return $data;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }


  public static function getProfitsForAGivenMonth($year, $month)
  {
    try {

      $totalSales = Sale::whereYear('date', $year)
        ->whereMonth('date', $month)
        ->sum('paid_amount');

      $totalBuyingCost = Sale::whereYear('date', $year)
        ->whereMonth('date', $month)
        ->sum('total_buying_cost');


      $totalExpenses = Expense::whereYear('date_of_expenditure', $year)
        ->whereMonth('date_of_expenditure', $month)
        ->sum('amount');

      $totalDamages = Damage::whereYear('recordedOn', $year)
        ->whereMonth('recordedOn', $month)
        ->sum('total_cost');

      $supplierDebts = (Supplier::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->sum('credit')) - (Supplier::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->sum('debt'));

      $customerDebts = Sale::where('fully_paid', 0)
        ->where('balance', '>', 0)
        ->whereYear('date', $year)
        ->whereMonth('date', $month)->sum('balance');

      $netProfitPerMonth = (($totalSales - $totalBuyingCost) - ($totalExpenses + $totalDamages) + ($supplierDebts + $customerDebts));

      return $netProfitPerMonth;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function getMonthlySalesData()
  {
    $year = date('Y');
    $result = DB::table('monthlysales')
      ->where('SalesYear', $year)
      ->orderBy('month_int', 'asc')
      ->get();
    $max_sale_value = DB::table('monthlysales')->max('TotalSales');
    $data = $months = $years = $sales = $profits = array();
    $totalProfits = 0;
    foreach ($result as $row) {

      $profitForEachMonth = Helper::getProfitsForAGivenMonth($row->SalesYear, $row->month_int);
      $totalProfits += $profitForEachMonth;

      array_push($months, date("F", mktime(0, 0, 0, $row->month_int, 10)));
      array_push($profits, $profitForEachMonth);
      array_push($years, $row->SalesYear);
      array_push($sales, $row->TotalSales);
    }
    $data = array(
      'months' => $months,
      'years' => $years,
      'sales' => $sales,
      'profits' => $profits,
      'max' => $max_sale_value
    );
    // dd($totalProfits);
    if (!empty($data)) {
      return $data;
    }
  }


  public static function getMonthlyPurchasesData()
  {
    $year = date('Y');

    $result = DB::select(DB::raw("SELECT MONTHNAME(created_at) as month, sum(cost_price_per_item) as purchases
        FROM purchases GROUP BY MONTH(created_at), MONTHNAME(created_at) ORDER BY MONTH(created_at)"));
    // dd($result);

    $data = $months = $purchases = array();

    foreach ($result as $row) {

      array_push($months, $row->month);
      array_push($purchases, $row->purchases);
    }
    $data = array(
      'months' => $months,
      'purchases' => $purchases
    );

    if (!empty($data)) {
      return $data;
    }
  }

  public static function convertNumber($number)
  {
    Helper::is_decimal($number)
      ? $number = number_format($number, 2)
      : $number = number_format($number);
    return $number;
  }

  public static function is_decimal($n)
  {
    return is_numeric($n) && floor($n) != $n;
  }


  public static function getLoggedInUserId()
  {
    $userId = Auth::user()->id;
    return $userId;
  }

  public static function getLoggedInUser()
  {
    $user = Auth::user()->first_name . ' ' . Auth::user()->last_name;
    return $user;
  }

  public static function generateUniqueNumber($table, $column = null, $length, $prefix)
  {
    try {

      $config = [
        'table' => $table,
        'length' => $length,
        'prefix' => $prefix
      ];

      if ($column != null) {
        $config['field'] = $column;
      }

      $order_number = IdGenerator::generate($config);
      return $order_number;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function findRoom($room_id)
  {
    try {
      $room = Room::find($room_id);
      return $room;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }
  public static function getMenuItem($menu_item_id)
  {
    try {
      $menuItem = KitchenMenuItem::find($menu_item_id);
      return $menuItem;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function createOrUpdatePurchase($row)
  {

    try {

      $id = $row['id'];
      if (isset($id)) {

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
          'date_of_purchase' => $row['date_of_purchase'],
        ];

        Purchase::where('id', $id)
          ->update($purchaseArr);
      } else {

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
    } catch (\Exception $ex) {
      throw $ex;
    }
  }


  public static function LogRequest(Request $request, $responseArr)
  {

    try {
      $r = new RequestResponse;
      $r->request = json_encode($request->all());
      $r->response = json_encode($responseArr);
      $r->method = $request->method() . ":" . $responseArr["method"];
      $r->url = $request->fullUrl();
      $r->ip_address = $request->ip();
      return $r->save();
    } catch (\Exception $ex) {
      throw $ex;
    }
  }


  public static function is_connectedToInternet()
  {
    $connected = @fsockopen('www.google.com', 80);
    if ($connected) {
      $is_conn = 1;
      fclose($connected);
    } else {
      $is_conn = 0;
    }

    return $is_conn;
  }

  public static function sendMail(
    $mailContentPage,
    $receiverEmail,
    $dataX,
    $dataY
  ) {

    $mailState = 0;
    $dataY['receiver'] = $receiverEmail;

    if (Helper::is_connectedToInternet() == 1) {

      Mail::send(
        $mailContentPage,
        $dataX,
        function ($message) use ($dataY) {
          $message->from(config('app.companyEmail'), 'Dallington');
          $message->to($dataY['receiver'])->subject($dataY['subject']);
        }
      );

      (Mail::failures())
        ? $mailState = 1
        : $mailState = -1;

      return $mailState;
    }
  }

  public static function logger(Request $request, $action, $date)
  {

    $newLog = new Logs();
    $user = $request->user();
    $newLog->name = $name = $user->firsname . ' ' . $user->last_name;
    $newLog->role = $userPosition = Helper::getDesignation($request->user()->designation_id);
    $newLog->logged_action = $action;
    $newLog->ip_address = \Request::getClientIp();
    $newLog->date = $date;

    $newLog->save();
    Log::channel('poslogs')->notice("" . $userPosition . " " . $name . " " . $action . "");
  }

  public static function generateStaffId($department_id)
  {
    try {

      $departmentObj = Department::find($department_id);
      $department_code = $departmentObj->code;

      $count = Staff::count();
      $latest_id = $count > 0 ? Staff::latest()->first()->id : 0;
      $staff_id = $department_code . str_pad($latest_id + 1, 4, '0', STR_PAD_LEFT);

      return $staff_id;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function createInvoicesDirIfnotExists($directory)
  {
    try {
      $path = public_path($directory);
      if (!File::exists($path)) {
        File::makeDirectory($path, 0777, true, true);
      }
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function getKitchenOrderStatuses(): array
  {
    try {
      $order_statuses = array();
      foreach (config('kitchen-order-statuses') as $status) {
        array_push($order_statuses, $status);
      }
      return $order_statuses;
    } catch (\Exception $ex) {
      throw $ex;
    }
  }

  public static function ActionMessage($action)
  {
    $message = "You have successfully " . $action . "";
    return $message;
  }

  public static function FailedMessage($failmsg)
  {
    return $failmsg;
  }




}
