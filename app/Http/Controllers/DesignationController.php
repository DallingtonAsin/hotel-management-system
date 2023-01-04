<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\DataTables\HR\DesignationsDataTable;
use Illuminate\Support\Facades\Validator;
use App\Models\Designation;
use Helper;

class DesignationController extends Controller
{

    public function index()
    {
        $total_designations = Designation::count();
        return view('pages.main.hr.designations')->with(compact('total_designations'));
    }

    public function getDesignationsDataTable(DesignationsDataTable $dataTable)
    {
        return $dataTable->render('pages.main.hr.designations');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.main.hr.designations');
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
            'department' => 'required|max:55',
            'designation' => 'required|max:55',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

            
                $department_id = $request->input('department');
                $name = $request->input('designation');
                $department = Department::where('id', $department_id)->value('name');
                $added_by = Helper::getLoggedInUser();

                if (
                    Designation::create([
                        'name' => $name,
                        'department_id' => $department_id,
                        'created_by' => $added_by
                    ])
                ) {
                    $message = "Designation " . $name . " has been added in " . $department . " department successfully";
                    $stats = $this->GetDesignationStats();
                    $data = [
                        'success' => $message,
                        'data' => $stats['data'],
                        'total' => $stats['total']
                    ];
                } else {

                    $message = "Technical error in adding designation";
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

    private function GetDesignationStats()
    {
        try {

            $designations = Designation::all();
            $total_designations = Designation::count();

            $data = array(
                'data' => $designations,
                'total' => $total_designations
            );

            return $data;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    public function fetchDesignationsAjax(Request $request, $department_id) {
        try {
            if($request->ajax()){
            $designations = Designation::where('department_id', $department_id)->get();
            echo json_encode($designations);
            die();
            
            }
        } catch (\Exception $ex) {
            echo "Error ".$ex->getMessage();
        }
    }
}