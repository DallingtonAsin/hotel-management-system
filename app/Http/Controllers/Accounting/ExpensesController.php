<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Helpers\Helper;
use App\Imports\ImportExpenses;
use App\Exports\ExportExpenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\DataTables\Finances\ExpensesDataTable;
use App\Models\ExpenseType;
use Illuminate\Support\Str;
use Constant;
use Excel;
use Illuminate\Support\Facades\Validator;

class ExpensesController extends Controller
{
  public $date_of_action, $controller;

  public function __construct()
  {
    $this->date_of_action = now();
    $this->controller = 'ExpensesController';
  }


  public function index()
  {
    $expenses = Expense::All();
    $expense_types = ExpenseType::all();
    $number_of_total_expenses = Expense::count();
    $total_expenses = DB::table('expenses')->sum('amount');
    return view('pages.main.expenses.index')->with(compact('expenses', 'expense_types', 'total_expenses', 'number_of_total_expenses'));
  }

  public function GetExpenses(ExpensesDataTable $dataTable)
  {

    return $dataTable->render('pages.main.expenses.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.main.expenses.index');
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
      'expense' => 'required',
      'expenditure_amount' => 'required',
      'date_of_expense' => 'required'
    ]);



    try {
      if ($validator->fails()) {
        $message = $validator->errors()->all();
        return response()->json(['error' => $message]);
      } else {

        $method = "ExpensesController@store";

        $expense_id = $request->input('id');
        $expense_type_id = $request->input('expense');
        $amount = Helper::Numberize($request->input('expenditure_amount'));
        $date_of_expenditure = $request->input('date_of_expense');

        $type_name = ExpenseType::where('id', $expense_type_id)->first()->name;
        $recorded_by  = Auth::user()->id;

        if (isset($expense_id)) {

          $expense = Expense::find($expense_id);
          $response = Expense::where('id', $expense_id)->update(
            [
              'type_id' => $expense_type_id,
              'amount' => $amount,
              'date_of_expenditure' => $date_of_expenditure,
              'recorded_by' => $recorded_by
            ]
          );

          $action = "updated expense " . $type_name . "";
        } else {

          $expense = new Expense;
          $expense->type_id = $expense_type_id;
          $expense->amount = $amount;
          $expense->date_of_expenditure = $date_of_expenditure;
          $expense->recorded_by = $recorded_by;
          $response = $expense->save();
          $action = "recorded expense " . $type_name . "";
        }

        if ($response) {

          Helper::logger($request, $action, now());
          $dataArr = array(
            "code" => '200',
            "message" => $action,
            "method" => $method
          );
          Helper::LogRequest($request, $dataArr);

          $message = $this->SuccessMessage($action);
          $arr = $this->GetTotlExpenses();
          return response()->json([
            'success' => $message,
            'totl_no' => $arr['totl_no'],
            'totl_expenses' => $arr['totl_expenses'],
          ]);
        } else {

          $messageErr = 'System has failed to record expense';
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


  private function getExpenseDetails($id)
  {
    try {
      $expense = Expense::find($id);
      $expense->type_name = ExpenseType::where('id', $expense->type_id)->first()->name;
      return response()->json($expense);
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
    return $this->getExpenseDetails($id);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    return $this->getExpenseDetails($id);
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
      'expense' => 'required',
      'expenditure_amount' => 'required',
      'date_of_expense' => 'required'

    ]);

    $expense = Expense::find($id);

    $expense->type_id = $expense_type_id = $request->input('expense');
    $expense->amount = Helper::Numberize($request->input('expenditure_amount'));
    $expense->date_of_expenditure = $request->input('date_of_expense');
    $expense->recorded_by = Auth::user()->id;
    

    $expense_update_status = $expense->save();

    if ($expense_update_status) {

      $action = "updated details of expense " . $expense_type_id . "";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "ExpensesController@update"
      );
      Helper::LogRequest($request, $dataArr);
      return back()->with('success', $this->SuccessMessage($action));
    } else {
      $messageErr = 'Expense Update failed!';
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "ExpensesController@update"
      );
      Helper::LogRequest($request, $dataArr);
      return back()->with('fail', $messageErr);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {

    try {

      $method = "ExpensesController@destroy";
      $expense_type_id = Expense::where('id', $id)->value('type_id');
      $type_name = ExpenseType::where('id', $expense_type_id)->first()->name;
      $response = Expense::find($id)->delete();

      if ($response) {

        $action = "deleted expense " . $type_name . " from the system";
        Helper::logger($request, $action, now());
        $dataArr = array(
          "code" => '200',
          "message" => $action,
          "method" => $method
        );
        Helper::LogRequest($request, $dataArr);

        $message = $this->SuccessMessage($action);
        $arr = $this->GetTotlExpenses();
        return response()
          ->json([
            'success' => $message,
            'totl_no' => $arr['totl_no'],
            'totl_expenses' => $arr['totl_expenses'],
          ]);
      } else {

        $messageErr = 'System has failed to delete expense';
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


  protected function GetTotlExpenses()
  {

    $totl_no = Expense::count();
    $totl_amt = Expense::sum('amount');
    $data = array(
      'totl_no' => $totl_no,
      'totl_expenses' => $totl_amt,
    );
    return $data;
  }


  public function deleteAllExpenses(Request $request)
  {

    $result = Expense::truncate();
    if ($result) {

      $action = "removed all expenses from the system";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "ExpensesController@deleteAllExpenses"
      );
      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'success';
      $responseInfo = $this->SuccessMessage($action);
      // return back()->with("success", $this->SuccessMessage($action));
    } else {
      $messageErr = "Expenses not removed from the system!";
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "ExpensesController@deleteAllExpenses"
      );
      Helper::LogRequest($request, $dataArr);
      $sessionVariable = 'fail';
      $responseInfo = $messageErr;
      // return back()->with('fail', $messageErr);
    }

    $arr = $this->GetTotlExpenses();
    return response()
      ->json([
        $sessionVariable => $responseInfo,
        'totl_no' => $arr['totl_no'],
        'totl_expenses' => $arr['totl_expenses'],
      ]);
  }


  public function RemoveSelected(Request $request)
  {
    try {
      $ids = $request->input('selected_rows');
      $deletedExpenses = array();

      if (count($ids) > 0) {
        foreach ($ids as $id) {
          $findId = Expense::find($id);
          $findId->delete();
          array_push($deletedExpenses, $findId->expense_type);
        }
      }
      $sessionVariable = 'success';
      $deletedExpensesStr = implode(", ", $deletedExpenses);
      $action = "removed expenses " . $deletedExpensesStr . " from the system";
      if (count($ids) == 1) {
        $action = Str::replaceFirst('expenses', 'expense', $action);
      }
      $response = $this->SuccessMessage($action);

      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "" . $this->controller . "@RemoveSelected"
      );
      Helper::logger($request, $action, now());
      Helper::LogRequest($request, $dataArr);

      $arr = $this->GetTotlExpenses();
      return response()
        ->json([
          $sessionVariable => $response,
          'totl_no' => $arr['totl_no'],
          'totl_expenses' => $arr['totl_expenses'],
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

  public function importExpenses(Request $request)
  {

    $this->validate(
      $request,
      ['select_file' => 'required|mimes:xls,xlsx'],
      ['select_file.mimes' => 'Please select only excel files to import expenses data']
    );

    $importSuccess = Excel::import(new ImportExpenses, request()->file('select_file'));
    if ($importSuccess) {

      $action = "imported an excel file of expenses into the system";
      Helper::logger($request, $action, now());
      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "ExpensesController@importExpenses"
      );
      Helper::LogRequest($request, $dataArr);

      return back()->with('success', $this->SuccessMessage($action));
    } else {
      $messageErr = 'Expenses data not imported!';
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => "ExpensesController@importExpenses"
      );
      Helper::LogRequest($request, $dataArr);
      return back()->with('fail', $messageErr);
    }
  }


  /**
   * @return \Illuminate\Support\Collection
   */
  public function exportExpenses()
  {
    return Excel::download(new ExportExpenses, 'expenses.xlsx');
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
