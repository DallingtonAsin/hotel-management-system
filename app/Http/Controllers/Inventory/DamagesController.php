<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Damage;
use App\Imports\ImportDamages;
use App\Exports\ExportDamages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\DataTables\Inventory\DamagesDataTable;
use Illuminate\Support\Str;
use App\Helpers\Constants as Constant;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\Helper;
use App\Models\Stock;
use Illuminate\Support\Facades\Validator;
use App\Repositories\DamagedStockRepository;

class DamagesController extends Controller
{

  public $controller;
  protected $damagedStockRepository;

  public function __construct(DamagedStockRepository $damagedStockRepository)
  {
    $this->controller = 'DamagesController';
    $this->damagedStockRepository = $damagedStockRepository;
  }

  public function GetDamages(DamagesDataTable $dataTable)
  {
    return $dataTable->render('pages.main.inventory.damages');
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
  
    $stock = Stock::all();
    $number_of_damages = Damage::count();
    $cost_of_damages = $this->damagedStockRepository->getCostofDamages();
    
    return view('pages.main.inventory.damages')->with(compact('stock', 'cost_of_damages', 'number_of_damages'));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.main.inventory.damages');
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
      'item_id' => 'required',
      'quantity' => 'required',
    ]);

    try {
      if ($validator->fails()) {
        $message = $validator->errors()->all();
        return response()->json(['error' => $message]);
      } else {

        $damage = new Damage;
        $item_id = $request->input('item_id');
        $quantity = Helper::Numberize($request->input('quantity'));
        $method = "DamagesController@store";


          $product = Stock::find($item_id);
          $current_quantity = $product->quantity;
          $new_quantity = ($current_quantity - $quantity);

          $damage = [
              'item_id' => $item_id,
              'quantity' => $quantity,
              'recorded_by' => Auth::user()->id
          ];

          if (Damage::create($damage)) {

            $is_stock_updated = $product->update(['quantity' => $new_quantity]);

            if ($is_stock_updated) {

              $action = "recorded damaged item " . $product->item_name . "";
              Helper::logger($request, $action, now());
              $dataArr = array(
                "code" => '200',
                "message" => $action,
                "method" => $method
              );
              Helper::LogRequest($request, $dataArr);
              $message = $this->SuccessMessage($action);

              $arr = $this->GetDamagesStats();
              $totl_no = $arr['totl_no'];
              $totl_amt = $arr['totl_amt'];

              return response()
                ->json([
                  'success' => $message,
                  'totl_no' => $totl_no,
                  'totl_amt' => $totl_amt,
                ]);


            } else {

              $error = "System has failed to update stock on recording damaged item";
              $dataArr = array(
                "code" => '101',
                "message" => $error,
                "method" => $method
              );
              Helper::LogRequest($request, $dataArr);

              $message = $this->FailedMessage($error);
              return response()->json(['error' => $message]);
            }

          } else {

            $error = "Unable to record damaged stock";
            $dataArr = array(
              "code" => '101',
              "message" => $error,
              "method" => $method
            );
            Helper::LogRequest($request, $dataArr);
            $message = $this->FailedMessage($error);
            return response()->json(['error' => $message]);

          }
      }

    } catch (\Exception $ex) {
      return response()->json(['error' => $ex->getMessage()]);
    }


  }


  private function getDamagedItemDetails($id){
          try{
            $damage = Damage::find($id);
            $damage->item_name = Stock::where('id', $damage->item_id)->value('item_name');
            return response()->json(['success' => 'ok', 'data' => $damage]);
          }catch(\Exception $ex){
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
     return $this->getDamagedItemDetails($id);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    return $this->getDamagedItemDetails($id);
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


  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {

    $damage = Damage::find($id);
    $method = "DamagesController@destroy";
    $item = $damage->item;
    $damage_delete_status = $damage->delete();
    if ($damage_delete_status) {

      $action = "deleted damaged item " . $item . " from the system";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => $method
      );

      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'success';
      $responseInfo = $this->SuccessMessage($action);

    } else {

      $messageErr = "Damaged item not deleted!";
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => $method
      );
      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'fail';
      $responseInfo = $this->FailedMessage($messageErr);

    }

    $arr = $this->GetDamagesStats();

    return response()
      ->json([
        $sessionVariable => $responseInfo,
        'totl_no' => $arr['totl_no'],
        'totl_amt' => $arr['totl_amt'],
      ]);

  }

  protected function GetDamagesStats()
  {
    $totl_no = Damage::count();
    $totl_cost = $this->damagedStockRepository->getCostofDamages();

    $data = array(
      'totl_no' => $totl_no,
      'totl_amt' => $totl_cost,
    );
    return $data;
  }


  protected function searchItem(Request $request)
  {

    if ($request->input('query')) {
      $query = $request->input('query');
      $data = array();
      $items = DB::table("stock")
        ->where("id", "like", "%" . $query . "%")
        ->orWhere("item", "like", "%" . $query . "%")
        ->get();

      foreach ($items as $item) {
        $data[] = $item->item;
        $data[] = $item->item_code;
      }
      echo json_encode($data);
    }

  }


  public function deleteAllDamages(Request $request)
  {

    $result = Damage::truncate();

    if ($result) {

      $action = "deleted all damaged items from the system";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "DamagesController@deleteAllDamages"
      );
      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'success';
      $responseInfo = $this->SuccessMessage($action);

    } else {
      $messageErr = "Damaged items not deleted from the system!";
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "DamagesController@deleteAllDamages"
      );
      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'fail';
      $responseInfo = $messageErr;

    }

    $arr = $this->GetDamagesStats();
    $totl_no = $arr['totl_no'];
    $totl_amt = $arr['totl_amt'];

    return response()
      ->json([
        $sessionVariable => $responseInfo,
        'totl_no' => $totl_no,
        'totl_amt' => $totl_amt,
      ]);

  }

  public function RemoveSelected(Request $request)
  {
    try {
      $ids = $request->input('selected_rows');
      $deletedDamagedItems = array();

      if (count($ids) > 0) {
        foreach ($ids as $id) {
          $findId = Damage::find($id);
          $findId->delete();
          array_push($deletedDamagedItems, $findId->item);
        }
      }
      $sessionVariable = 'success';
      $deleteddamagedStockStr = implode(", ", $deletedDamagedItems);
      $action = "removed damaged items " . $deleteddamagedStockStr . " from the system";
      if (count($ids) == 1) {
        $action = Str::replaceFirst('items', 'item', $action);
      }
      $response = $this->SuccessMessage($action);

      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "" . $this->controller . "@RemoveSelected"
      );
      Helper::logger($request, $action, now());
      Helper::LogRequest($request, $dataArr);

      $arr = $this->GetDamagesStats();
      $totl_no = $arr['totl_no'];
      $totl_amt = $arr['totl_amt'];

      return response()
        ->json([
          $sessionVariable => $response,
          'totl_no' => $totl_no,
          'totl_amt' => $totl_amt,
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



  public function importDamages(Request $request)
  {
    $this->validate(
      $request,
      ['select_file' => 'required|mimes:xls,xlsx'],
      ['select_file.mimes' => 'Please select only excel files to import damages']
    );

    $importSuccess = Excel::import(new ImportDamages, request()->file('select_file'));
    if ($importSuccess) {

      $action = "imported an excel file of damaged items into the system";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "DamagesController@importDamages"
      );
      Helper::LogRequest($request, $dataArr);
      return back()->with('success', $this->SuccessMessage($action));
    } else {
      $messageErr = "Damages data not imported!!";
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "DamagesController@importDamages"
      );
      Helper::LogRequest($request, $dataArr);
      return back()->with('fail', $messageErr);
    }
  }

  //method that gets details of damaged item from stock
  public function getdetailsofDamagedItem($item)
  {
    $data_obj = DB::select('select item_code,category,buying_price  from stock where item = ?', [$item]);
    return $data_obj;
  }

  //method that gets list of items in stock
  public function getItems_in_Stock()
  {
    $items = DB::table('stock')->select('item')->get();
    return $items;
  }

  //Get Available quantity of a product before recording a damage
  public function getQtyBeforeAddingDamage($item)
  {
    $data = DB::select('select quantity from stock where item = ?', [$item]);
    foreach ($data as $value) {
      $qty = $value->quantity;
    }
    return $qty;
  }

  //Get recorded quantity of a damage before making update
  public function getRecordedQtyBeforeUpdatingDamage($item)
  {
    $data = DB::select('select quantity from damages where item = ?', [$item]);
    foreach ($data as $value) {
      $qty = $value->quantity;
    }
    return $qty;
  }





  /**
   * @return \Illuminate\Support\Collection
   */
  public function exportDamages()
  {
    return Excel::download(new ExportDamages, 'damages.xlsx');
  }

  protected function SuccessMessage($msg)
  {
    $message = "You have successfully " . $msg . "";
    return $message;
  }


  protected function FailedMessage($failmsg)
  {
    return $failmsg;
  }




} //end of the class
