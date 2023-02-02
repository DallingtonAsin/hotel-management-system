<?php

namespace App\Http\Controllers\Reports;


use Illuminate\Http\Request;
use App\DataTables\Reports\TopCustomersDataTable;
use App\DataTables\Reports\MonthlySalesDataTable;
use App\DataTables\Reports\SupplierDebtorsDataTable;
use App\DataTables\Reports\LowRunningStockDataTable;
use App\DataTables\Reports\CustomerDebtorsDataTable;
use App\DataTables\Reports\BestSellingItemsDataTable;
use App\DataTables\Reports\CashiersPerformanceDataTable;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Services\ReportService;

class ReportsController extends Controller
{

  protected $reportService;
  public function __construct(ReportService $reportService)
  {
    $this->reportService = $reportService;
  }

  public function index(Request $request)
  {
    return view(
      'pages.reports.index',
      ['chartdata' => Helper::getMonthlySalesData()]
    );
  }

  public function purchaseReports(Request $request)
  {
    return view(
      'pages.reports.purchases_charts',
      ['chartdata' => Helper::getMonthlyPurchasesData()]
    );
  }

  public function GetLowStockDT(LowRunningStockDataTable $dataTable)
  {
    return $dataTable->render('pages.reports.lowstock');
  }

  public function GetTopCustomersDT(TopCustomersDataTable $dataTable)
  {
    return $dataTable->render('pages.reports.topcustomers');
  }

  public function GetMonthlySalesDT(MonthlySalesDataTable $dataTable)
  {
    return $dataTable->render('pages.reports.monthlysales');
  }

  public function GetSupplierDebtorsDT(SupplierDebtorsDataTable $dataTable)
  {
    return $dataTable->render('pages.reports.debtors-suppliers');
  }

  public function GetCustomerDebtorsDT(CustomerDebtorsDataTable $dataTable)
  {
    return $dataTable->render('pages.reports.debtors-customers');
  }

  public function GetBestSellingItemsDT(BestSellingItemsDataTable $dataTable)
  {
    return $dataTable->render('pages.reports.bestsellingitems');
  }

  public function GetCashiersReportDT(CashiersPerformanceDataTable $dataTable)
  {
    return $dataTable->render('pages.reports.cashiersPerformance');
  }

  public function monthlyExpensesReportIndex()
  {
    $monthly_expenses = $this->reportService->getMonthlyExpensesData();
    $piechart_data = $this->reportService->getMonthlyExpensesPieChartData();
    return view('pages.reports.expenses.monthly')->with(compact('monthly_expenses', 'piechart_data'));
  }


  public function getQuery()
  {
    $query = DB::select('CALL getMonthlyExpensesReport()');
    return $query;
  }

  

  public function getMonthlyExpensesReport()
  {
    $query = $this->getQuery();
    return DataTables::of($query)
    ->editColumn('total', function ($report) {
      return number_format($report->total);
  })->addIndexColumn()
      ->make(true);
  }

  public function lowRunningStock(Request $request, $qty)
  {

    if ($request->input('qty')) {
      $quantity = $request->input('qty');
      $lowdata = Stock::whereColumn('quantity', '<=', 'threshold_qty')->get();
    } else {
      $lowdata = Stock::whereColumn('quantity', '<=', 'threshold_qty')->get();
    }
    return view('pages.reports.lowstock', ['lowstock' => $lowdata]);
  }

  public function MonthlySales()
  {
    return view('pages.reports.monthlysales');
  }

  public function BestSellingItems()
  {
    return view('pages.reports.bestsellingitems');
  }

  public function topCustomers()
  {
    return view('pages.reports.topcustomers');
  }


  public function topCashiers()
  {
    return view('pages.reports.cashiersPerformance');
  }

  public function debtorsCustomersList()
  {
    return view('pages.reports.debtors-customers');
  }


  public function debtorsSuppliersList()
  {
    return view('pages.reports.debtors-suppliers');
  }

}