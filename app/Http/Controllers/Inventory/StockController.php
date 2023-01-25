<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\StockCat;
use App\Imports\ImportStock;
use App\Exports\ExportStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\DataTables\Inventory\StockDataTable;
use Illuminate\Support\Str;
use App\Helpers\Constants as Constant;
use App\Helpers\Helper;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use App\Services\Api\StockService;
use App\Repositories\StockRepository;
use App\Repositories\SupplierRepository;


class StockController extends Controller
{

  private $controller;
  protected $stockRepository, $supplierRepository, $stockService;

  public function __construct(StockRepository $stockRepository, StockService $stockService,
                              SupplierRepository $supplierRepository)
  {
    $this->controller = 'StockController';
    $this->stockRepository = $stockRepository;
    $this->supplierRepository = $supplierRepository;
    $this->stockService = $stockService;
  }

  public function index()
  {
    $stock = Stock::all(); //DB::select('exec GetStockProc');
    $number_of_stockItems = Stock::count();
    $stock_value = DB::table('stock')->sum('total_cost_price');
    $categories = StockCat::get();
    $suppliers = DB::table('suppliers')->get();
    return view('pages.main.inventory.stock')->with(compact('stock', 'stock_value', 'categories', 'suppliers', 'number_of_stockItems'));
  }


  public function GetStock(StockDataTable $dataTable)
  {
    return $dataTable->render('pages.main.inventory.stock');
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
      'item_code' => 'required',
      'goods_type_code' => 'required',
      'stockin_type_code' => 'required',
      'supplier' => 'required',
      'quantity' => 'required',
      'original_price' => 'required',
      'selling_price' => 'required',
      'threshold_qty' => 'sometimes|nullable',
      'remarks' => 'sometimes|nullable',
    ]);

    try {
      if ($validator->fails()) {

        $message = $validator->errors()->all();
        return response()->json(['error' => $message]);
      } else {

        $item_code = $request->input('item_code');
        $code_exists = Stock::where('item_code', $item_code)->exists();

        if ($code_exists) {
          return response()->json(['error' => 'Stock item with code ' . $item_code . ' does not exist in the system. Please just update.']);
        } else {

          $stock = new Stock;
          $method = "StockController@store";

          $buying_price = Helper::Numberize($request->input('original_price'));
          $selling_price = Helper::Numberize($request->input('selling_price'));
          if($buying_price > $selling_price){
            return response()->json(['error' => 'Buying price cannot be greater than selling price']);
          }

          $item_name = $request->input('item');
          $goods_type_code = $request->input('goods_type_code');
          $stockin_type_code = $request->input('stockin_type_code');
          $quantity = Helper::Numberize($request->input('quantity'));
          $supplier_id = $request->input('supplier');
          $expiry_date = $request->input('expiry_date');
          $remarks = $request->input('remarks');
          $supplier = $this->supplierRepository->get($supplier_id);

          $efris_request_data = [
            'goodsCode' => $item_code,
            'goodsTypeCode' => $goods_type_code,
            'quantity' => $quantity,
            'unitPrice' => $selling_price,
            'stockInType' => $stockin_type_code,
            'supplierTin' => $supplier->tin,
            'supplierName' => $supplier->name,
            'remarks' => $remarks
          ];

          $apiResponse = $this->stockService->addStock($efris_request_data);
          $apiResponse = json_decode(json_encode($apiResponse->getData()), true);

          if ($apiResponse['statusCode'] ==  200) {

            $threshold_quantity = null;
            $expiry_date = null;

            if ($request->filled('threshold_qty')) {
              $threshold_quantity = Helper::Numberize($request->input('threshold_qty'));
            }

            $stock = [
              'item_code' => $item_code,
              'item_name' => $item_name,
              'goods_type_code' => $goods_type_code,
              'stockin_type_code' => $stockin_type_code,
              'supplier_id' => $supplier_id,
              'quantity' => $quantity,
              'threshold_qty' => $threshold_quantity,
              'buying_price' => $buying_price,
              'selling_price' => $selling_price,
              'expiry_date' => empty($expiry_date) ? "" : $expiry_date,
              'remarks' => $remarks,
              'created_by' => Auth::user()->id,
            ];

            if ($this->stockRepository->create($stock)) {

              $action = "recorded stock item " . $item_name . " in the system";
              Helper::logger($request, $action, now());
              $dataArr = array(
                "code" => '200',
                "message" => $action,
                "method" => $method
              );

              Helper::LogRequest($request, $dataArr);

              $message = Helper::ActionMessage($action);
              $arr = $this->getStockStats();

              return response()
                ->json([
                  'success' => $message,
                  'data' => $arr
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
          } else {
            return response()->json(['error' => $apiResponse['message']]);
          }
        }
      }
    } catch (\Exception $ex) {
      return response()->json(['error' => 'Unable to upload stock on EFRIS because of' . $ex->getMessage()]);
    }
  }


  public function increaseStock(Request $request, $id)
  {

    if (!empty($id)) {

      $validator = Validator::make($request->all(), [
        'item_code' => 'required',
        'goods_type_code' => 'required',
        'quantity' => 'required',
        'selling_price' => 'required',
        'stockin_type_code' => 'required',
        'supplier' => 'required',
        'remarks' => 'sometimes|nullable',
      ]);

      try {
        if ($validator->fails()) {

          $message = $validator->errors()->all();
          return response()->json(['error' => $message]);
        } else {

          $item_code = $request->input('item_code');
          $code_exists = $this->stockRepository->exists($id);

          if (!$code_exists) {
            return response()->json(['error' => 'Product code ' . $item_code . ' does not exist in the stock']);
          } else {

            $method = "StockController@increaseStock";

            $item_name = $this->stockRepository->get($id)->item_name;

            $supplier_id = $request->input('supplier');
            $goods_type_code = $request->input('goods_type_code');
            $stockin_type_code = $request->input('stockin_type_code');
            $quantity = Helper::Numberize($request->input('quantity'));
            $selling_price = Helper::Numberize($request->input('selling_price'));
            $remarks = $request->input('remarks');
            $supplier = $this->supplierRepository->get($supplier_id);


            $efris_request_data = [
              'goodsCode' => $item_code,
              'goodsTypeCode' => $goods_type_code,
              'quantity' => $quantity,
              'unitPrice' => $selling_price,
              'stockInType' => $stockin_type_code,
              'supplierTin' => $supplier->tin,
              'supplierName' => $supplier->name,
              'remarks' => $remarks
            ];

            // dd($efris_request_data);

            $apiResponse = $this->stockService->increaseStock($efris_request_data);
            $apiResponse = json_decode(json_encode($apiResponse->getData()), true);

            if ($apiResponse['statusCode'] ==  200) {

              $is_updated = $this->stockRepository->increase($id, $quantity);

              if ($is_updated) {

                $action = "increased quantity for stock item " . $item_name . " by " . $quantity . " in the system";
                Helper::logger($request, $action, now());

                $dataArr = array(
                  "code" => '200',
                  "message" => $action,
                  "method" => $method
                );

                Helper::LogRequest($request, $dataArr);

                $message = Helper::ActionMessage($action);
                $arr = $this->getStockStats();

                return response()
                  ->json([
                    'success' => $message,
                    'data' => $arr
                  ]);
              } else {

                $messageErr = "System has failed to update stock quantity";

                $dataArr = array(
                  "code" => '101',
                  "message" => $messageErr,
                  "method" => $method
                );

                Helper::LogRequest($request, $dataArr);
                $message = $this->FailedMessage($messageErr);
                return response()->json(['error' => $message]);
              }
            } else {
              return response()->json(['error' => $apiResponse['message']]);
            }
          }
        }
      } catch (\Exception $ex) {
        return response()->json(['error' => 'Unable to increase stock on EFRIS because of ' . $ex->getMessage()]);
      }
    } else {
      return response()->json(['error' => 'Unable to get stock item id']);
    }
  }



  public function decreaseStock(Request $request, $id)
  {

    if (!empty($id)) {

      $validator = Validator::make($request->all(), [
        'item_code' => 'required',
        'quantity' => 'required',
        'selling_price' => 'required',
        'adjust_type' => 'required',
        'remarks' => 'sometimes|nullable'
      ]);

      try {
        if ($validator->fails()) {

          $message = $validator->errors()->all();
          return response()->json(['error' => $message]);
        } else {

          $item_code = $request->input('item_code');
          $code_exists = $this->stockRepository->exists($id);

          if (!$code_exists) {
            return response()->json(['error' => 'Product code ' . $item_code . ' does not exist in the stock']);
          } else {

            $method = "StockController@decreaseStock";
            $item_name = $this->stockRepository->get($id)->item_name;
            $quantity = Helper::Numberize($request->input('quantity'));
            $selling_price = Helper::Numberize($request->input('selling_price'));
            $adjust_type = $request->input('adjust_type');
            $remarks = $request->input('remarks');

            $efris_request_data = [
              'goodsCode' => $item_code,
              'quantity' => $quantity,
              'unitPrice' => $selling_price,
              'adjustType' => $adjust_type,
              'remarks' => $remarks
            ];

            $apiResponse = $this->stockService->decreaseStock($efris_request_data);
            $apiResponse = json_decode(json_encode($apiResponse->getData()), true);

            if ($apiResponse['statusCode'] ==  200) {

              $is_updated = $this->stockRepository->decrease($id, $quantity);

              if ($is_updated) {

                $action = "decreased quantity for stock item " . $item_name . " by " . $quantity . " in the system";
                Helper::logger($request, $action, now());

                $dataArr = array(
                  "code" => '200',
                  "message" => $action,
                  "method" => $method
                );

                Helper::LogRequest($request, $dataArr);

                $message = Helper::ActionMessage($action);
                $arr = $this->getStockStats();

                return response()
                  ->json([
                    'success' => $message,
                    'data' => $arr
                  ]);
              } else {

                $messageErr = "System has failed to update stock";

                $dataArr = array(
                  "code" => '101',
                  "message" => $messageErr,
                  "method" => $method
                );

                Helper::LogRequest($request, $dataArr);
                $message = $this->FailedMessage($messageErr);
                return response()->json(['error' => $message]);
              }
            } else {
              return response()->json(['error' => $apiResponse['message']]);
            }
          }
        }
      } catch (\Exception $ex) {
        return response()->json(['error' => 'Unable to decrease stock on EFRIS because of ' . $ex->getMessage()]);
      }
    } else {
      return response()->json(['error' => 'Unable to get stock item id']);
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

  private function getProductDetails($id)
  {
    try {
      $data = Stock::find($id);
      $data->supplier_tin = Supplier::where('id', $data->supplier_id)->first()->tin;
      return response()->json(['success' => 'Ok', 'data' => $data]);
    } catch (\Exception $ex) {
      return response()->json(['error' => $ex->getMessage()]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return $this->getProductDetails($id);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    return $this->getProductDetails($id);
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

    $validator = Validator::make($request->all(), [
      'item' => 'required',
      'item_code' => 'sometimes|nullable',
      'category' => 'sometimes|nullable',
      'supplier' => 'sometimes|nullable',
      'quantity' => 'required',
      'original_price' => 'required',
      'selling_price' => 'required',
      'threshold_qty' => 'sometimes|nullable',
    ]);

    try {
      if ($validator->fails()) {

        $message = $validator->errors()->all();
        return response()->json(['error' => $message]);
      } else {

        $stock = Stock::find($id);
        $stock->item_name = $item = $request->input('item');
        $stock->item_code = $request->input('item_code');

        empty($request->input('supplier'))
          ? $stock->supplier_id = $stock->supplier_id
          : $stock->supplier_id = $request->input('supplier');

        $stock->quantity = Helper::Numberize($request->input('quantity'));

        $expiry_date = $request->input('expiry_date');
        $stock->buying_price = Helper::Numberize($request->input('original_price'));
        $stock->selling_price = Helper::Numberize($request->input('selling_price'));

        $request->filled("threshold_qty")
          ? $threshold_quantity = Helper::Numberize($request->input("threshold_qty"))
          : $threshold_quantity = 0;

        $stock->threshold_qty = $threshold_quantity;

        (empty($expiry_date)) ? $stock->expiry_date = "" : $stock->expiry_date = $expiry_date;
        ($expiry_date == "mm/dd/yyyy") ? $stock->expiry_date = "" : $stock->expiry_date = $expiry_date;

        if ($stock->save()) {

          $action = "updated details of stock item " . $item . "";
          Helper::logger($request, $action, now());
          $dataArr = array(
            "code" => '200',
            "message" => $action,
            "method" => "StockController@update"
          );
          Helper::LogRequest($request, $dataArr);

          $arr = $this->getStockStats();
          $message = Helper::ActionMessage($action);
          return response()
            ->json([
              'success' => $message,
              'data' => $arr
            ]);
        } else {
          $messageErr = "Stock Update failed!";
          $dataArr = array(
            "code" => '101',
            "message" => $messageErr,
            "method" => "StockController@update"
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

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {

    if (!empty($id)) {
      try {
        $stock = Stock::find($id);
        $item_name = $stock->item_name;

        if ($stock->update(['is_deleted' => true])) {

          $action = "removed item " . $item_name . " from list of stock items";
          Helper::logger($request, $action, now());
          $dataArr = array(
            "code" => '200',
            "message" => $action,
            "method" => "StockController@destroy"
          );
          Helper::LogRequest($request, $dataArr);

          $message = Helper::ActionMessage($action);
          $arr = $this->getStockStats();

          return response()
            ->json([
              'success' => $message,
              'data' => $arr
            ]);
        } else {

          $error = "System unable to delete";
          $dataArr = array(
            "code" => '101',
            "message" => $error,
            "method" => "StockController@destroy"
          );
          Helper::LogRequest($request, $dataArr);
          $message = $this->FailedMessage($error);
          return response()->json(['error' => $message]);
        }
      } catch (\Exception $ex) {
        return response()->json(['error' => $ex->getMessage()]);
      }
    } else {
      return response()->json(['error' => 'System is unable to capture item id']);
    }
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
      $responseInfo = Helper::ActionMessage($action);
      //return back()->with("success", Helper::ActionMessage($action));
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

      return back()->with('success', Helper::ActionMessage($action));
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
