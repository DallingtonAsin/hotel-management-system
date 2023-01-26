<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DataTables\HR\DepartmentsDatatable;
use App\Models\Department;
use App\Helpers\Helper;

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
     * return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'name' => 'required',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $code = $request->input('code');
                $name = ucfirst($request->input('name'));
                $exists = Department::where('code', $code)
                        ->orWhere('name', $name)->exists();
                        
                if($exists){
                    return response()->json(['error' => 'Department code '.$code.' or name '.$name.' already exists']);
                } else {

                    $created_by = Helper::getLoggedInUserId();
                    $data = [
                        'code' => $code,
                        'name' => $name,
                        'created_by' => $created_by
                    ];

                    if (Department::create($data)) {
                        $message = "Department " . $name . " has been added successfully";
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
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    private function sendJson($id){
        $data = Department::find($id);
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