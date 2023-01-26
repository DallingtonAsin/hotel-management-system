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
use App\Helpers\Constants as Constant;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ExpenseRepository;

class ExpensesController extends Controller
{

  protected $date_of_action, $controller;
  protected $expenseRepository;

  public function __construct(ExpenseRepository $expenseRepository)
  {
    $this->date_of_action = now();
    $this->controller = 'ExpensesController';
    $this->expenseRepository = $expenseRepository;
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
        $expense_type_id = $request->input('expense');
        $amount = Helper::Numberize($request->input('expenditure_amount'));
        $date_of_expenditure = $request->input('date_of_expense');

        $type_name = ExpenseType::where('id', $expense_type_id)->first()->name;
        $recorded_by  = Auth::user()->id;

        $expense = [
          'type_id' => $expense_type_id,
          'amount' => $amount,
          'date_of_expenditure' => $date_of_expenditure,
          'recorded_by' => $recorded_by
        ];


        if ($this->expenseRepository->create($expense)) {

          $action = "recorded expense " . $type_name . "";

          Helper::logger($request, $action, now());
          $dataArr = array(
            "code" => '200',
            "message" => $action,
            "method" => $method
          );
          Helper::LogRequest($request, $dataArr);

          $message = Helper::ActionMessage($action);
          $arr = $this->GetTotlExpenses();
          return response()->json(['success' => $message, 'data' => $arr]);
        } else {

          $error = 'System has failed to record expense';
          $dataArr = array(
            "code" => '101',
            "message" => $error,
            "method" => $method
          );
          Helper::LogRequest($request, $dataArr);
          $message = Helper::FailedMessage($error);

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

        $expense = Expense::find($id);

        $expense_type_id = $request->input('expense');
        $amount = Helper::Numberize($request->input('expenditure_amount'));
        $date_of_expenditure = $request->input('date_of_expense');
        $recorded_by = Auth::user()->id;

        $expense = [
          'type_id' => $expense_type_id,
          'amount' => $amount,
          'date_of_expenditure' => $date_of_expenditure,
          'recorded_by' => $recorded_by
        ];

        if ($this->expenseRepository->update($id, $expense)) {

          $type_name = ExpenseType::where('id', $expense_type_id)->first()->name;
          $message = "updated details of expense " . $type_name . "";

          Helper::logger($request, $message, now());
          $dataArr = array(
            "code" => '200',
            "message" => $message,
            "method" => "ExpensesController@update"
          );

          Helper::LogRequest($request, $dataArr);
          $arr = $this->GetTotlExpenses();
          return response()->json([
            'success' =>  Helper::ActionMessage($message),
            'data' => $arr
          ]);
        } else {

          $error = 'System is unable to update expense';
          $dataArr = array(
            "code" => '101',
            "message" => $error,
            "method" => "ExpensesController@update"
          );

          Helper::LogRequest($request, $dataArr);
          return response()->json(['error' => $error]);
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
   * return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {

    try {

      if ($id) {

        $id = intval($id);
        $method = "ExpensesController@destroy";
        $expense = Expense::find($id);
        $expense_type_id = $expense->type_id;

        if ($this->expenseRepository->update($id, ['is_deleted' => true])) {

          $type_name = ExpenseType::where('id', $expense_type_id)->first()->name;
          $action = "deleted expense " . $type_name . " from the system";
          Helper::logger($request, $action, now());

          $dataArr = array(
            "code" => '200',
            "message" => $action,
            "method" => $method
          );
          Helper::LogRequest($request, $dataArr);

          $message = Helper::ActionMessage($action);
          $arr = $this->GetTotlExpenses();
          return response()->json([
            'success' => $message,
            'data' => $arr
          ]);
        } else {

          $error = 'System has failed to delete expense';
          $dataArr = array(
            "code" => '101',
            "message" => $error,
            "method" => $method
          );

          Helper::LogRequest($request, $dataArr);
          $error = Helper::FailedMessage($error);
          return response()->json(['error' => $error]);
        }
      } else {
        return response()->json(['error' => 'System is unable to find expense id']);
      }
    } catch (\Exception $ex) {
      return response()->json(['error' => $ex->getMessage()]);
    }
  }


  private function GetTotlExpenses()
  {

    $total_no = $this->expenseRepository->count();
    $total_amt = $this->expenseRepository->value();
    $data = array(
      'total' => $total_no,
      'value' => $total_amt,
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

      $message = Helper::ActionMessage($action);
      $arr = $this->GetTotlExpenses();
      return response()->json(['success' => $message, 'data' => $arr]);
    } else {

      $error = "Expenses not removed from the system!";
      $dataArr = array(
        "code" => '101',
        "message" => $error,
        "method" => "ExpensesController@deleteAllExpenses"
      );

      Helper::LogRequest($request, $dataArr);
      return response()->json(['error' => $error]);
    }
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
      $response = Helper::ActionMessage($action);

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
          'data' => $arr
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

      return back()->with('success', Helper::ActionMessage($action));
    } else {
      $error = 'Expenses data not imported!';
      $dataArr = array(
        "code" => '101',
        "message" => $error,
        "method" => "ExpensesController@importExpenses"
      );
      Helper::LogRequest($request, $dataArr);
      return back()->with('fail', $error);
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
}
