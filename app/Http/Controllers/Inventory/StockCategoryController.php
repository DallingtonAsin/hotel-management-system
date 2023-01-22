<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\StockCat;
use App\Imports\ImportStockCats;
use App\Exports\ExportStockCats;
use Illuminate\Http\Request;
use App\DataTables\Inventory\StockCatsDataTable;
use Illuminate\Support\Str;
use Constant;
use Excel;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StockCategoryController extends Controller
{

  public $controller;
  public function __construct()
  {
    $this->controller = 'StockCategoryController';
  }


  public function StockCatAjaxIndex(StockCatsDataTable $dataTable)
  {
    return $dataTable->render('pages.main.stock.product-categories');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $pdt_categories = StockCat::all();
    $total_categories = StockCat::count();
    return view('pages.main.stock.product-categories', ['total_categories' => $total_categories])
      ->with(compact('pdt_categories', 'total_categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.main.stock.product-categories');
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
      'name' => 'required'
    ]);

    try {
      if ($validator->fails()) {
        $message = $validator->errors()->all();
        return response()->json(['error' => $message]);
      } else {

        $name = $request->input('name');
        $created_by = Auth::user()->id;

        if (StockCat::create(['name' => $name, 'created_by' => $created_by])) {

          $action = "recorded stock category " . $name . "";
          Helper::logger($request, $action, now());
          $dataArr = array(
            "code" => '200',
            "message" => $action,
            "method" => "StockCategoryController@store"
          );

          Helper::LogRequest($request, $dataArr);
          $message = $this->SuccessMessage($action);
          $totl = $this->GetStockCatStats();

          return response()->json([
            'success' => $message,
            'totl_no' => $totl,
          ]);
        } else {

          $messageErr = 'Item category not recorded!';
          $dataArr = array(
            "code" => '101',
            "message" => $messageErr,
            "method" => "StockCategoryController@store"
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


  protected function GetStockCatStats()
  {
    $totl_catItems = StockCat::count();
    return $totl_catItems;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $itemCat = StockCat::find($id);
    return response()->json($itemCat);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $itemCat = StockCat::find($id);
    return response()->json($itemCat);
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
      'name' => 'required',
    ]);

    $pdt_category = StockCat::find($id);

    $pdt_category->item_category = $itemCategory = request('name');

    $pdt_category_update_status = $pdt_category->save();

    if ($pdt_category_update_status) {

      $action = "updated details of stock category " . $itemCategory . "";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "StockCategoryController@update"
      );
      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'success';
      $responseInfo = $this->SuccessMessage($action);
    } else {
      $messageErr = 'Item categoryUpdate failed!';
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "StockCategoryController@update"
      );
      Helper::LogRequest($request, $dataArr);

      $sessionVariable = 'fail';
      $responseInfo = $this->FailedMessage($messageErr);
    }

    $totl = $this->GetStockCatStats();

    return response()
      ->json([
        $sessionVariable => $responseInfo,
        'totl_no' => $totl,
      ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @eturn \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {

    try {

      $method = "StockCategoryController@destroy";
      $pdt_category = StockCat::find($id);
      $itemCategory = $pdt_category->item_category;
      $isDeleted = $pdt_category->delete();

      if ($isDeleted) {

        $action = "removed stock category " . $itemCategory . "";
        Helper::logger($request, $action, now());
        $dataArr = array(
          "code" => '200',
          "message" => $action,
          "method" => $method
        );

        Helper::LogRequest($request, $dataArr);
        $message = $this->SuccessMessage($action);
        $totl = $this->GetStockCatStats();

        return response()
          ->json([
            'success' => $message,
            'totl_no' => $totl,
          ]);
      } else {

        $messageErr = 'Item category not deleted!!';
        $dataArr = array(
          "code" => '101',
          "message" => $messageErr,
          "method" => $method
        );
        Helper::LogRequest($request, $dataArr);
        $message = $this->FailedMessage($messageErr);
        return response()->json(['error' => $message]);
      }
    } catch (\Exception $ex) {
      return response()->json(['error' => $ex->getMessage()]);
    }
  }


  public function deleteAllStockCategories(Request $request)
  {

    $result = StockCat::truncate();
    if ($result) {
      $action = "deleted all stock categories from the system";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "StockCategoryController@deleteAllStockCategories"
      );
      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'success';
      $responseInfo = $this->SuccessMessage($action);
    } else {
      $messageErr = 'stock item categories not deleted from the system!';
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "StockCategoryController@deleteAllStockCategories"
      );
      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'fail';
      $responseInfo = $messageErr;
    }

    $totl = $this->GetStockCatStats();

    return response()
      ->json([
        $sessionVariable => $responseInfo,
        'totl_no' => $totl,
      ]);
  }


  public function RemoveSelected(Request $request)
  {
    try {
      $ids = $request->input('selected_rows');
      $deletedStockCats = array();

      if (count($ids) > 0) {
        foreach ($ids as $id) {
          $findId = StockCat::find($id);
          $findId->delete();
          array_push($deletedStockCats, $findId->item_category);
        }
      }
      $sessionVariable = 'success';
      $deletedStockCatsStr = implode(", ", $deletedStockCats);
      $action = "removed stock categories " . $deletedStockCatsStr . " from the system";
      if (count($ids) == 1) {
        $action = Str::replaceFirst('categories', 'category', $action);
      }
      $response = $this->SuccessMessage($action);

      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "" . $this->controller . "@RemoveSelected"
      );
      Helper::logger($request, $action, now());
      Helper::LogRequest($request, $dataArr);

      $totl = $this->GetStockCatStats();
      return response()
        ->json([
          $sessionVariable => $response,
          'totl_no' => $totl,
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
      return response()->json(['error' => $ex->getMessage()]);
    }
  }


  public function importCategories(Request $request)
  {
    $this->validate(
      $request,
      ['select_file' => 'required|mimes:xls,xlsx'],
      ['select_file.mimes' => 'Please select only excel files to import stock categories data']
    );
    $importSuccess = Excel::import(new ImportStockCats, request()->file('select_file'));
    if ($importSuccess) {
      $action = "imported an excel file of stock categories into the system";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "StockCategoryController@importCategories"
      );
      Helper::LogRequest($request, $dataArr);
      return back()
        ->with('success', $this->SuccessMessage($action));
    } else {
      $messageErr = 'Categories data not imported!';
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "StockCategoryController@importCategories"
      );
      Helper::LogRequest($request, $dataArr);
      return back()
        ->with('fail', $messageErr);
    }
  }


  /**
   * @return \Illuminate\Support\Collection
   */
  public function exportCategories()
  {
    return Excel::download(new ExportStockCats, 'stock-categories.xlsx');
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
}
