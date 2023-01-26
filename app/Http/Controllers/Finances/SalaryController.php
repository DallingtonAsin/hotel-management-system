<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Finances\SalariesDataTable;
use Illuminate\Support\Facades\Validator;
use App\Models\Salary;
use App\Helpers\Helper;
use App\Models\Staff;

class SalaryController extends Controller
{
   
    public function index()
    {
        $total_salaries = Salary::count();
        return view('pages.main.hr.finances.salary')->with(compact('total_salaries'));
    }

    public function getSalariesDataTable(SalariesDataTable $dataTable)
    {
        return $dataTable->render('pages.main.hr.finances.salary');
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
     * return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $employee_id = $request->input('employee');
                $amount = Helper::Numberize($request->input('amount'));
                $payment_date = $request->input('payment_date');
                $employee = Staff::find($employee_id);
                $employee_name = $employee->first_name . ' ' . $employee->last_name;

                $created_by = Helper::getLoggedInUserId();
                $salary_details = [
                    'employee_id' => $employee_id,
                    'amount' => $amount,
                    'pay_date' => $payment_date,
                    'created_by' => $created_by
                ];

                if (
                    Salary::create($salary_details)
                ) {
                    $message = "Salary for " . $employee_name . " has been recorded successfully";
                    $stats = $this->GetSalaryStats();
                    $data = [
                        'success' => $message,
                        'data' => $stats['data'],
                        'total' => $stats['total']
                    ];
                } else {

                    $message = "Technical error in adding salary details";
                    $data = [
                        'error' => $message
                    ];
                }
                return response()->json($data);
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    private function sendJson($id){
        $data = Salary::find($id);
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->sendJson($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->sendJson($id);

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

    private function GetSalaryStats()
    {
        try {

            $salary = Salary::all();
            $total_salary = Salary::count();

            $data = array(
                'data' => $salary,
                'total' => $total_salary
            );

            return $data;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}
