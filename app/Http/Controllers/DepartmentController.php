<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\DataTables\HR\DepartmentsDatatable;
use App\Models\Department;
use Helper;

class DepartmentController extends Controller
{

    public function index()
    {
        $total_departments = Department::count();
        return view('pages.main.hr.departments')->with(compact('total_departments'));
    }

    public function getDepartmentsDataTable(DepartmentsDatatable $dataTable)
    {
        return $dataTable->render('pages.main.hr.departments');
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
            'name' => 'required|max:55',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {
                $name = $request->input('name');
                $added_by = Helper::getLoggedInUser();
                if (Department::create(['name' => $name, 'created_by' => $added_by])) {
                    $message = "Department " . $name . " added successfully";
                    $stats = $this->GetDepartmentStats();
                    $data = [
                        'success' => $message,
                        'data' => $stats['data'],
                        'total' => $stats['total']
                    ];
                } else {
                    $message = "Technical error in adding department";
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function fetchDepartmentsAjax(Request $request)
    {
        try {
            if ($request->ajax()) {
                $departments = Department::get();
                echo json_encode($departments);
                die();

            }
        } catch (\Exception $ex) {
            echo "Error " . $ex->getMessage();
        }
    }
    private function GetDepartmentStats()
    {
        try {

            $departments = Department::all();
            $total_departments = Department::count();

            $data = array(
                'data' => $departments,
                'total' => $total_departments
            );

            return $data;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}