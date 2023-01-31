<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\DataTables\Finances\Sales\SalesDataTable;
use App\DataTables\Finances\Sales\SalesWithDebtsDataTable;
use App\DataTables\Finances\Sales\TodaySalesDataTable;
use App\DataTables\Finances\Sales\TodaySalesWithDebtsDataTable;
use Illuminate\Support\Str;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\Expense;
use App\Models\Customer;
use App\Repositories\DamagedStockRepository;
use App\Helpers\Helper;
use App\Helpers\Constants as Constant;
use Yajra\DataTables\Facades\DataTables as DataTable;
use App\Repositories\SaleRepository;
use App\Repositories\StockRepository;
use App\Repositories\StaffRepository;


class SalesController extends Controller
{

  protected $saleRepository, $stockRepository, $controller;
  protected $staffRepository, $damagedStockRepository, $salesDataTable;

  public function __construct(SaleRepository $saleRepository, StockRepository $stockRepository,
                              StaffRepository $staffRepository,  DamagedStockRepository $damagedStockRepository,
                               SalesDataTable $salesDataTable)
  {
    $this->controller = 'SalesController';
    $this->staffRepository = $staffRepository;
    $this->saleRepository = $saleRepository;
    $this->stockRepository =  $stockRepository;
    $this->damagedStockRepository = $damagedStockRepository;
    $this->salesDataTable = $salesDataTable;
  }

  protected function GetCustomSalesReview($startDate, $endDate)
  {


    $value1 = Sale::whereBetween('date', [$startDate, $endDate])->sum('total_buying_cost');
    $total_sales = $value2 = Sale::whereBetween('date', [$startDate, $endDate])->sum('paid_amount');

    $total_expenses = Expense::whereBetween('date_of_expenditure', [$startDate, $endDate])->sum('amount');
    $cost_of_damages = $this->damagedStockRepository->getCostofDamages();

    $value3 = (Supplier::whereDate('created_at', ">=", $startDate)
      ->whereDate('created_at', "<=", $endDate)
      ->sum('credit'))
      - (Supplier::whereDate('created_at', ">=", $startDate)
        ->whereDate('created_at', "<=", $endDate)
        ->sum('debt'));

    $value4 = (Customer::whereDate('created_at', ">=", $startDate)
      ->whereDate('created_at', "<=", $endDate)
      ->sum('credit'))
      - (Customer::whereDate('created_at', ">=", $startDate)
        ->whereDate('created_at', "<=", $endDate)
        ->sum('debt'));

    $netValue = (($value2 - $value1) - ($total_expenses + $cost_of_damages) + ($value3 + $value4));

    return $netValue;
  }



  public function filterSales(Request $request)
  {

    if ($request->input('to')) {

      $startDate = $request->input('from');
      $endDate = $request->input('to');

      $data = DB::table('sales')
        ->whereBetween('date', [$startDate, $endDate])
        ->orderBy('date', 'desc')->get();

      $totl_filtered = DB::table('sales')
        ->whereBetween('date', [$startDate, $endDate])
        ->count();

      $volume_of_filteredsales = DB::table('sales')
        ->whereBetween('date', [$startDate, $endDate])
        ->sum('paid_amount');

      $netValue = $this->GetCustomSalesReview($startDate, $endDate);

      return DataTable::of($data)->addIndexColumn()
        ->addColumn('checkbox', function ($sale) {
          $checkBox = '<input type="checkbox" id="' . $sale->id . '"/>';
          return $checkBox;
        })->addColumn('item', function ($sale) {
            return $this->stockRepository->get($sale->item_id)->item_name;
        })->editColumn('quantity', function ($data) {
          return Helper::convertNumber($data->quantity);
        })->editColumn('selling_price', function ($data) {
          return Helper::convertNumber($data->selling_price);
        })->editColumn('amount', function ($data) {
          return Helper::convertNumber($data->amount);
        })->editColumn('paid_amount', function ($data) {
          return Helper::convertNumber($data->paid_amount);
        })->editColumn('balance', function ($data) {
          return Helper::convertNumber($data->balance);
        })->editColumn('discount', function ($data) {
          return Helper::convertNumber($data->discount);
        })->addColumn('action', function ($sale) {

          $btn = "";

          $btn .= '<a href="javascript:void(0);" id="view-sale"
            data-toggle="tooltip" data-original-title="View"
             data-id="' . $sale->id . '" class="text-info bolded pl-4">
            <i class="fa fa-eye" ></i></a>';

          if (Gate::allows('isAdmin')) {

            $btn .= '<a href="javascript:void(0);" id="delete-sale"
            data-toggle="tooltip" data-original-title="Delete"
             data-id="' . $sale->id . '" class="trash-btn pl-4">
            <span class="fa fa-trash-alt"></span></a>';
          }

          return $btn;
        })->rawColumns(['action', 'checkbox'])
        ->with([
          "totl_filtered" => $totl_filtered,
          "volume" => $volume_of_filteredsales,
          "netValue" => $netValue,
        ])
        ->make(true);
    }
    return view('pages.main.sales.index');
  }

  public function filterSalesWithDebts(Request $request)
  {

    if ($request->input('to')) {

      $startDate = $request->input('from');
      $endDate = $request->input('to');

      $data = DB::table('sales')
        ->whereBetween('date', [$startDate, $endDate])
        ->where('is_credit', 1)
        ->where('fully_paid', 0)
        ->where('balance', '>', 0)
        ->orderBy('date', 'desc')->get();

      $totl_filtered = DB::table('sales')
        ->whereBetween('date', [$startDate, $endDate])
        ->where('is_credit', 1)
        ->where('fully_paid', 0)
        ->where('balance', '>', 0)
        ->count();

      $volume_of_filteredsales = DB::table('sales')
        ->whereBetween('date', [$startDate, $endDate])
        ->where('is_credit', 1)
        ->where('fully_paid', 0)
        ->where('balance', '>', 0)
        ->sum('balance');

      $netValue = $this->GetCustomSalesReview($startDate, $endDate);

      return DataTable::of($data)->addIndexColumn()
        ->addColumn('checkbox', function ($sale) {
          $checkBox = '<input type="checkbox" id="' . $sale->id . '"/>';
          return $checkBox;
        })->editColumn('quantity', function ($data) {
          return Helper::convertNumber($data->quantity);
        })->editColumn('selling_price', function ($data) {
          return Helper::convertNumber($data->selling_price);
        })->editColumn('amount', function ($data) {
          return Helper::convertNumber($data->amount);
        })->editColumn('paid_amount', function ($data) {
          return Helper::convertNumber($data->paid_amount);
        })->editColumn('balance', function ($data) {
          return Helper::convertNumber($data->balance);
        })->editColumn('discount', function ($data) {
          return Helper::convertNumber($data->discount);
        })->addColumn('action', function ($sale) {

          $btn = "";

          $btn .= '<a href="javascript:void(0);" id="view-sale"
          data-toggle="tooltip" data-original-title="View"
           data-id="' . $sale->id . '" class="text-info bolded pl-4">
          <i class="fa fa-eye" ></i></a>';

          if (Gate::allows('isAdmin')) {

            $btn .= '<a href="javascript:void(0);" id="delete-sale"
          data-toggle="tooltip" data-original-title="Delete"
           data-id="' . $sale->id . '" class="trash-btn pl-4">
          <span class="fa fa-trash-alt"></span></a>';
          }

          return $btn;
        })->rawColumns(['action', 'checkbox'])->with([
          "totl_filtered" => $totl_filtered,
          "volume" => $volume_of_filteredsales,
          "netValue" => $netValue,
        ])->make(true);
    }
    return view('pages.main.sales.debts');
  }



  public function GetSales()
  {
    return $this->salesDataTable->render('pages.main.sales.index');
  }

  public function GetTodaySales(TodaySalesDataTable $dataTable)
  {
    return $dataTable->render('pages.main.sales.debts');
  }

  public function GetSalesWithDebts(SalesWithDebtsDataTable $dataTable)
  {
    return $dataTable->render('pages.main.sales.debts');
  }

  public function GetTodaySalesWithDebts(TodaySalesWithDebtsDataTable $dataTable)
  {
    return $dataTable->render('pages.main.sales.index');
  }




  protected function GetDailySalesReview()
  {

    $total_number_of_sales = Sale::where('date', Date('Y-m-d'))->count();
    $value1 = Sale::where('date', Date('Y-m-d'))->sum('total_buying_cost');
    $total_sales = $value2 = Sale::where('date', Date('Y-m-d'))->sum('paid_amount');
    $total_expenses = Expense::where('date_of_expenditure', Date('Y-m-d'))->sum('amount');
    $cost_of_damages = $this->damagedStockRepository->getCostofDamages();
    $value3 = (Supplier::whereDate('created_at', Date('Y-m-d'))->sum('credit')) - (Supplier::whereDate('created_at', Date('Y-m-d'))->sum('debt'));
    $value4 = (Customer::whereDate('created_at', Date('Y-m-d'))->sum('credit')) - (Customer::whereDate('created_at', Date('Y-m-d'))->sum('debt'));

    $netValue = (($value2 - $value1) - ($total_expenses + $cost_of_damages) + ($value3 + $value4));

    $data = array(
      'totl_no' => $total_number_of_sales,
      'totl_sales' => $total_sales,
      'NetWorth' => $netValue
    );
    return $data;
  }

  public function salesForToday(Request $request)
  {

    $request->session()->forget('filtered_sales');
    $arr = $this->GetDailySalesReview();
    $today = Date('Y-m-d');

    $today_sales = Sale::whereDate('date', $today)->get();
    $all_sales = Sale::where('date', Date('Y-m-d'))->get();

    $volume_of_todaysales = Sale::whereDate('date', $today)
      ->sum('paid_amount');

    $totl_no =  $arr['totl_no'];
    $total_sales =  $arr['totl_sales'];
    $netValue =  $arr['NetWorth'];

    ($netValue > 0)
      ? $net_title = "Net Profit made: shs"
      : $net_title = "Losses made: shs";

    if ($request->ajax()) {
      $this->GetSales();
    }
    $menu_selected = 'sales';

    return view('pages.main.sales.index')->with(
      compact(
        'today_sales',
        'totl_no',
        'all_sales',
        'netValue',
        'volume_of_todaysales',
        'total_sales',
        'menu_selected'
      )
    );
  }



  public function index(Request $request)
  {

    $request->session()->forget('filtered_sales');
    $arr = $this->GetSalesReview();
    $today = Date('Y-m-d');

    $today_sales = Sale::whereDate('date', $today)->get();
    $all_sales = Sale::where('fully_paid', 1)->where('balance', 0)->get();

    $volume_of_todaysales = Sale::whereDate('date', $today)
      ->sum('paid_amount');

    $totl_no = $arr['totl_no'];
    $total_sales = $arr['totl_sales'];
    $netValue = $arr['NetWorth'];

    ($netValue > 0)
      ? $net_title = "Net Profit made: shs"
      : $net_title = "Losses made: shs";

    if ($request->ajax()) {
      $this->GetSales();
    }

    return view('pages.main.sales.index')->with(
      compact(
        'today_sales',
        'totl_no',
        'all_sales',
        'netValue',
        'volume_of_todaysales',
        'total_sales'
      )
    );
  }



  public function salesWithDebtsIndex(Request $request)
  {

    $request->session()->forget('filtered_sales');
    $arr = $this->GetSalesWithDebtsReview();
    $today = Date('Y-m-d');

    $today_sales = Sale::where('is_credit', 1)->where('fully_paid', 0)->where('balance', '>', 0)->whereDate('date', $today)->get();
    $all_sales = Sale::where('is_credit', 1)->where('fully_paid', 0)->where('balance', '>', 0)->get();

    $volume_of_todaysales = Sale::where('is_credit', 1)->where('fully_paid', 0)->where('balance', '>', 0)->whereDate('date', $today)
      ->sum('balance');

    $totl_no = $arr['totl_no'];
    $total_sales = $arr['totl_sales'];
    $netValue = $arr['NetWorth'];

    ($netValue > 0)
      ? $net_title = "Net Profit made: shs"
      : $net_title = "Losses made: shs";

    if ($request->ajax()) {
      $this->GetSales();
    }

    return view('pages.main.sales.debts')->with(
      compact(
        'today_sales',
        'totl_no',
        'all_sales',
        'netValue',
        'volume_of_todaysales',
        'total_sales'
      )
    );
  }


  private function GetSalesReview()
  {
    $total_number_of_sales = Sale::where('fully_paid', 1)->where('balance', 0)->count();
    $total_sales = Sale::sum('paid_amount');
    $total_expenses = Expense::sum('amount');
    $cost_of_damages = 0; // Damage::sum('total_cost');
    $total_initial_cost = Sale::sum('total_buying_cost');
    $supplier_debts = (Supplier::sum('credit')) - (Supplier::sum('debt'));
    $customer_debts = Sale::where('fully_paid', 0)->where('balance', '>', 0)->sum('balance');
    $netValue = (($total_sales - $total_initial_cost) - ($total_expenses + $cost_of_damages) + ($supplier_debts + $customer_debts));

    $data = array(
      'totl_no' => $total_number_of_sales,
      'totl_sales' => $total_sales,
      'NetWorth' => $netValue
    );
    return $data;
  }

  private function GetSalesWithDebtsReview()
  {

    $today = Date('Y-m-d');
    if (Gate::allows('isAdmin')) {

      $total_number_of_sales = Sale::where('is_credit', 1)->where('fully_paid', 0)->where('balance', '>', 0)->count();
      $total_sales = Sale::where('is_credit', 1)->where('fully_paid', 0)->where('balance', '>', 0)->sum('balance');
      $total_expenses = Expense::sum('amount');
      $cost_of_damages = 0; //  Damage::sum('total_cost');
      $total_initial_cost = Sale::sum('total_buying_cost');
      $supplier_debts = (Supplier::sum('credit')) - (Supplier::sum('debt'));
      $customer_debts = Sale::where('is_credit', 1)->where('fully_paid', 0)->where('balance', '>', 0)->sum('balance');
      $netValue = (($total_sales - $total_initial_cost) - ($total_expenses + $cost_of_damages) + ($supplier_debts + $customer_debts));
    } else {

      $total_number_of_sales = Sale::whereDate('date', $today)->where('is_credit', 1)->where('fully_paid', 0)->where('balance', '>', 0)->count();
      $total_sales = Sale::whereDate('date', $today)->where('is_credit', 1)->where('fully_paid', 0)->where('balance', '>', 0)->sum('balance');
      $netValue = 0;
    }


    $data = array(
      'totl_no' => $total_number_of_sales,
      'totl_sales' => $total_sales,
      'NetWorth' => $netValue
    );
    return $data;
  }



  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.main.sales.index');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }


  private function getSaleDetails($id){
    try{

      $sale = Sale::find($id);
      $sale->item_name = $this->stockRepository->get($sale->item_id)->item_name;
      $staff = $this->staffRepository->get($sale->cashier_id);
      $sale->cashier_name = $staff->first_name . ' '. $staff->last_name;

      return response()->json(['success' => 'OK', 'data' => $sale]);
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
     return $this->getSaleDetails($id);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    return $this->getSaleDetails($id);
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

  public function updateSaleRecord(Request $request)
  {

    if ($request->has('item_id')) {

      $item_id = $request->input('item_id');
      $date_of_sale = $request->input('date_of_sale');
      $sale = Sale::find($item_id);
      $recordedSaleDate = $sale->date;
      $item_sale_date = isset($date_of_sale) ? $date_of_sale : $recordedSaleDate;

      $sale->date = $item_sale_date;
      $saveResponse = $sale->save();

      if ($saveResponse) {

        $action = "updated date of sale for sold item " . $sale->item . "";
        Helper::logger($request, $action, now());
        $dataArr = array(
          "code" => '200',
          "message" => $action,
          "method" => "" . $this->controller . "@updateSaleRecord"
        );
        Helper::LogRequest($request, $dataArr);
        $sessionVariable = 'success';
        $responseInfo = Helper::ActionMessage($action);
      } else {
        $error = "Unable to update sale details of item " . $sale->item . "!";
        $dataArr = array(
          "code" => '101',
          "message" => $error,
          "method" => "" . $this->controller . "@updateSaleRecord"
        );
        Helper::LogRequest($request, $dataArr);
        $sessionVariable = 'error';
        $responseInfo = Helper::FailedMessage($error);
      }
    } else {
      $error = "Unable to find sale item id";
      $dataArr = array(
        "code" => '101',
        "message" => $error,
        "method" => "" . $this->controller . "@updateSaleRecord"
      );
      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'error';
      $responseInfo = Helper::FailedMessage($error);
    }

    $arr = $this->GetSalesReview();
    return response()
      ->json([
        $sessionVariable => $responseInfo,
        'totl_no' => $arr['totl_no'],
        'totl_sales' => $arr['totl_sales'],
        'net_worth' => $arr['NetWorth'],
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

    $sale = Sale::find($id);
    $sale_item = $sale->item;
    $sale_delete_status = $sale->delete();
    if ($sale_delete_status) {

      $action = "deleted item " . $sale_item . " from list of sold items in the system";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "" . $this->controller . "@store"
      );
      Helper::LogRequest($request, $dataArr);

      $sessionVariable = 'success';
      $responseInfo = Helper::ActionMessage($action);
    } else {
      $error = "Sale not deleted!";
      $dataArr = array(
        "code" => '101',
        "message" => $error,
        "method" => "" . $this->controller . "@store"
      );
      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'fail';
      $responseInfo = Helper::FailedMessage($error);
    }

    $arr = $this->GetSalesReview();
    return response()
      ->json([
        $sessionVariable => $responseInfo,
        'totl_no' => $arr['totl_no'],
        'totl_sales' => $arr['totl_sales'],
        'net_worth' => $arr['NetWorth'],
      ]);
  }

  public function RemoveSelected(Request $request)
  {
    try {
      $ids =  $request->input('selected_rows');
      $deletedSales = array();

      if (count($ids) > 0) {
        foreach ($ids as $id) {
          $findId = Sale::find($id);
          $findId->delete();
          array_push($deletedSales, $findId->item);
        }
      }
      $sessionVariable = 'success';
      $deletedSalesStr = implode(", ", $deletedSales);
      $action = "removed sale items " . $deletedSalesStr . " from the system";
      if (count($ids) == 1) {
        $action = Str::replaceFirst('items', 'item', $action);
      }
      $response = Helper::ActionMessage($action);

      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "" . $this->controller . "@RemoveSelected"
      );
      Helper::logger($request, $action, now());
      Helper::LogRequest($request, $dataArr);

      $arr = $this->GetSalesReview();
      return response()
        ->json([
          $sessionVariable => $response,
          'totl_no' => $arr['totl_no'],
          'totl_sales' => $arr['totl_sales'],
          'net_worth' => $arr['NetWorth'],
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

  public function GetItem($id)
  {
    $item = Sale::where('id', $id)->value('item');
    return response()
      ->json(['item' => $item]);
  }



  /**
   * @return \Illuminate\Support\Collection
   */
  protected function ActionMessage($action)
  {
    $message = "You have successfully " . $action . "";
    return $message;
  }

  protected function SuccessMessage($action)
  {
    $message = "You have successfully " . $action . "";
    return $message;
  }
}
