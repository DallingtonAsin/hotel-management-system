<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\StockCat;
use App\Imports\ImportStock;
use App\Exports\ExportStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\DataTables\Inventory\StockDataTable;
use Illuminate\Support\Str;
use Constant;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;


class StockController extends Controller
{

  public $controller;
  public function __construct()
  {
    $this->controller = 'StockController';
  }

  public function index()
  {
    $stock = Stock::all(); //DB::select('exec GetStockProc');
    $number_of_stockItems = Stock::count();
    $stock_value = DB::table('stock')->sum('total_cost_price');
    $categories = StockCat::get();
    $suppliers = DB::table('suppliers')->get();
    return view('pages.main.stock.stock')->with(compact('stock', 'stock_value', 'categories', 'suppliers', 'number_of_stockItems'));
  }


  public function GetStock(StockDataTable $dataTable)
  {
    //if(Auth::check()){
    return $dataTable->render('pages.main.stock.stock');
    // }else{
    //    return redirect('/');
    // }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.main.stock.stock');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'item' => 'required',
      'quantity' => 'required',
      'original_price' => 'required',
      'selling_price' => 'required'
    ]);

    try {
      if ($validator->fails()) {
        $message = $validator->errors()->all();
        return response()->json(['error' => $message]);
      } else {

        $stock = new Stock;
        $method = "StockController@store";

        $item_code = $request->input('item_code');
        $item = $request->input('item');
        $category = $request->input('category');
        $supplier = $request->input('supplier');
        $quantity = Helper::Numberize($request->input('quantity'));
        ($request->has('thresholdQty') && $request->filled("thresholdQty"))
          ? $thresholdQty = Helper::Numberize($request->input("thresholdQty"))
          : $thresholdQty = 0;


        $expiry_date = $request->input('expiry_date');
        $buying_price = Helper::Numberize($request->input('original_price'));
        $selling_price = Helper::Numberize($request->input('selling_price'));
        $wholesale_price = Helper::Numberize($request->input('wholesale_price'));


        $stock->item_code = $item_code;
        $stock->item = $item;
        $stock->category = $category;
        $stock->supplier = $supplier;
        $stock->quantity = $quantity;
        $stock->threshold_qty = $thresholdQty;
        $stock->buying_price = $buying_price;
        $stock->selling_price = $selling_price;
        $stock->wholesale_price = $wholesale_price;
        $stock->expiry_date = empty($expiry_date) ? "" : $expiry_date;
        $saveStockResponse = $stock->save();

        // $purchase = new Purchase;
        //   $purchase->item_code = $item_code;
        //   $purchase->item = $item;
        //   $purchase->quantity = $quantity;
        //   $purchase->cost_price_per_item = $buying_price;
        //   $purchase->supplier = $supplier;
        //   $purchase->created_by =  $request->user()->name;
        //   $purchase->date = now();
        //  ($expiry_date == "mm/dd/yyyy")? $stock->expiry_date = "" : $stock->expiry_date =$expiry_date;
        //   $savePurchaseResponse = $purchase->save();

        if ($saveStockResponse) {

          $action = "recorded stock item " . $item . " in the system";
          Helper::logger($request, $action, now());
          $dataArr = array(
            "code" => '200',
            "message" => $action,
            "method" => $method
          );

          Helper::LogRequest($request, $dataArr);

          $message = $this->ActionMessage($action);
          $arr = $this->getStockStats();

          return response()
            ->json([
              'success' => $message,
              'totl_stock' => $arr['totl'],
              'stock_value' => $arr['value'],
            ]);

        } else {

          $messageErr = "System has failed to add stock item";

          $dataArr = array(
            "code" => '101',
            "message" => $messageErr,
            "method" => $method
          );

          Helper::LogRequest($request, $dataArr);
          $message = $this->FailedMessage($messageErr);
          return response()->json(['error' => $message]);
        }
      }
    } catch (\Exception $ex) {
      return response()->json(['error' => $ex->getMessage()]);
    }





  }

  protected function getStockStats()
  {
    $totl = Stock::count();
    $stockValue = Stock::sum('total_cost_price');
    $data = array(
      'totl' => $totl,
      'value' => $stockValue,
    );
    return $data;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {

    $items = Stock::find($id);
    return response()->json($items);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $items = Stock::find($id);
    return response()->json($items);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {

    $request->validate([

      'item' => 'required',
      'quantity' => 'required',
      'original_price' => 'required',
      'selling_price' => 'required',

    ]);

    $stock = Stock::find($id);
    $stock->item_code = $request->input('item_code');
    $stock->item = $item = $request->input('item');

    $stock->category = $request->input('category');

    empty($request->input('category'))
      ? $stock->category = $stock->category
      : $stock->category = $request->input('category');

    empty($request->input('supplier'))
      ? $stock->supplier = $stock->supplier
      : $stock->supplier = $request->input('supplier');

    $stock->quantity = Helper::Numberize($request->input('quantity'));

    $expiry_date = $request->input('expiry_date');
    $stock->buying_price = Helper::Numberize($request->input('original_price'));
    $stock->selling_price = Helper::Numberize($request->input('selling_price'));
    $stock->wholesale_price = Helper::Numberize($request->input('wholesale_price'));

    ($request->has('thresholdQty') && $request->filled("thresholdQty"))
      ? $thresholdQty = Helper::Numberize($request->input("thresholdQty"))
      : $thresholdQty = 0;
    $stock->threshold_qty = $thresholdQty;
    (empty($expiry_date)) ? $stock->expiry_date = "" : $stock->expiry_date = $expiry_date;
    ($expiry_date == "mm/dd/yyyy") ? $stock->expiry_date = "" : $stock->expiry_date = $expiry_date;

    $saveResponse = $stock->save();
    if ($saveResponse) {

      $action = "updated details of stock item " . $item . "";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "StockController@update"
      );
      Helper::LogRequest($request, $dataArr);

      $sessionVariable = 'success';
      $responseInfo = $this->ActionMessage($action);

    } else {
      $messageErr = "Stock Update failed!";
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "StockController@update"
      );
      Helper::LogRequest($request, $dataArr);

      $sessionVariable = 'fail';
      $responseInfo = $this->FailedMessage($messageErr);

    }

    $arr = $this->getStockStats();

    return response()
      ->json([
        $sessionVariable => $responseInfo,
        'totl_stock' => $arr['totl'],
        'stock_value' => $arr['value'],
      ]);

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {
    $stock = Stock::find($id);
    $stock_item = $stock->item;
    $stock_delete_status = $stock->delete();
    if ($stock_delete_status) {

      $action = "removed item " . $stock_item . " from list of stock items";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "StockController@destroy"
      );
      Helper::LogRequest($request, $dataArr);

      $sessionVariable = 'success';
      $responseInfo = $this->ActionMessage($action);
    } else {
      $messageErr = "item not removed!";
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "StockController@destroy"
      );
      Helper::LogRequest($request, $dataArr);

      $sessionVariable = 'fail';
      $responseInfo = $this->FailedMessage($messageErr);
    }

    $arr = $this->getStockStats();

    return response()
      ->json([
        $sessionVariable => $responseInfo,
        'totl_stock' => $arr['totl'],
        'stock_value' => $arr['value'],
      ]);

  }

  public function deleteAllStockItems(Request $request)
  {

    $result = Stock::truncate();
    if ($result) {
      $sessionVariable = 'success';
      $action = "deleted all stock items from the system";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "StockController@deleteAllStockItems"
      );
      Helper::LogRequest($request, $dataArr);
      $responseInfo = $this->ActionMessage($action);
      //return back()->with("success", $this->ActionMessage($action));
    } else {
      $sessionVariable = 'fail';
      $messageErr = "stock items not deleted from the system!";
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "StockController@deleteAllStockItems"
      );
      Helper::LogRequest($request, $dataArr);
      $responseInfo = $this->FailedMessage($messageErr);
      //return back()->with('fail', $messageErr);
    }

    $arr = $this->getStockStats();

    return response()
      ->json([
        $sessionVariable => $responseInfo,
        'totl_stock' => $arr['totl'],
        'stock_value' => $arr['value'],
      ]);

  }

  public function RemoveSelected(Request $request)
  {
    try {
      $ids = $request->input('selected_rows');
      $deletedStock = array();

      if (count($ids) > 0) {
        foreach ($ids as $id) {
          $findId = Stock::find($id);
          $findId->delete();
          array_push($deletedStock, $findId->item);
        }
      }
      $sessionVariable = 'success';
      $deletedStockStr = implode(", ", $deletedStock);
      $action = "removed stock " . $deletedStockStr . " from the system";
      if (count($ids) == 1) {
        $action = Str::replaceFirst('stock', 'stock item', $action);
      }
      $response = $this->SuccessMessage($action);

      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "" . $this->controller . "@RemoveSelected"
      );
      Helper::logger($request, $action, now());
      Helper::LogRequest($request, $dataArr);

      $arr = $this->getStockStats();

      return response()
        ->json([
          $sessionVariable => $response,
          'totl_stock' => $arr['totl'],
          'stock_value' => $arr['value'],
        ]);


    } catch (\Exception $ex) {
      $data = array(
        'username' => auth()->user()->username,
        'error_code' => $ex->getCode(),
        'error_message' => $ex->getMessage(),
        'error_severity' => Constant::$STATUS_ERROR_SEVERITY,
        'controller' => $this->controller,
        'method' => 'RemoveSelected'
      );
      Helper::logError($data);
      abort(409, $ex->getMessage());
    }
  }

  public function importStock(Request $request)
  {
    $this->validate(
      $request,
      ['select_file' => 'required|mimes:xls,xlsx'],
      ['select_file.mimes' => 'Please select only excel files to import stock data']
    );
    $importSuccess = Excel::import(new ImportStock, request()->file('select_file'));

    if ($importSuccess) {

      $action = "imported an excel file of stock items into the system";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "StockController@importStock"
      );
      Helper::LogRequest($request, $dataArr);

      return back()->with('success', $this->ActionMessage($action));
    } else {
      $messageErr = "Excel stock data not imported!";
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "StockController@importStock"
      );
      Helper::LogRequest($request, $dataArr);
      return back()->with('fail', $messageErr);
    }


  }


  /**
   * @return \Illuminate\Support\Collection
   */
  public function exportStock()
  {
    return Excel::download(new ExportStock, 'stock.xlsx');
  }

  protected function SuccessMessage($action)
  {
    $message = "You have successfully " . $action . "";
    return $message;
  }

  protected function FailedMessage($failmsg)
  {
    return $failmsg;
  }

  protected function ActionMessage($action)
  {
    $message = "You have successfully " . $action . "";
    return $message;
  }

  public function fetchStockItemsAjax(Request $request)
  {
    try {
      if ($request->ajax()) {

        $stock = Stock::all();
        echo json_encode($stock);
        die();

      }
    } catch (\Exception $ex) {
      echo "Error " . $ex->getMessage();
    }
  }





}