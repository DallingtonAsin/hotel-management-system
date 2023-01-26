<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Finances\ExpenseTypesDataTable;
use App\Repositories\ExpenseTypeRepository;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class ExpenseTypeController extends Controller
{

    protected $expenseTypeRepository;
    public function __construct(ExpenseTypeRepository $expenseTypeRepository)
    {
        $this->expenseTypeRepository = $expenseTypeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_expense_types = $this->expenseTypeRepository->count();
        return view('pages.main.expenses.types')->with(compact('total_expense_types'));
    }

    public function getExpenseTypesDataTable(ExpenseTypesDataTable $dataTable)
    {
        return $dataTable->render('pages.main.expenses.types');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

                $method = "ExpensesController@store";

                $name = $request->input('name');
                if ($this->expenseTypeRepository->checkIfExpenseNameExists($name)) {
                    return response()->json(['error' => 'Expense type name ' . $name . ' already exists']);
                } else {

                    $expense_type = [
                        'name' => $name,
                        'created_by' => Auth::user()->id,
                    ];

                    if ($this->expenseTypeRepository->create($expense_type)) {
                        $action = "added expense type " . $name . "";

                        Helper::logger($request, $action, now());
                        $dataArr = ["code" => '200', "message" => $action, "method" => $method];
                        Helper::LogRequest($request, $dataArr);

                        $message = Helper::ActionMessage($action);
                        $arr['total'] = $this->expenseTypeRepository->count();

                        return response()->json(['success' => $message,  'data' => $arr]);
                    } else {

                        $messageErr = 'System has failed to add expense type';
                        $dataArr = ["code" => '101', "message" => $messageErr,  "method" => $method];

                        Helper::LogRequest($request, $dataArr);
                        $message = Helper::FailedMessage($messageErr);

                        return response()->json(['error' => $message]);
                    }
                }
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    private function getExpenseTypeDetails($id)
    {
        try {

            $expense_type = $this->expenseTypeRepository->get($id);
            return response()->json(['success' => 'Ok', 'data' => $expense_type]);
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
        return $this->getExpenseTypeDetails($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->getExpenseTypeDetails($id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
