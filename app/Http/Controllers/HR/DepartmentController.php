<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DataTables\HR\DepartmentsDatatable;
use App\Models\Department;
use App\Helpers\Helper;
use App\Repositories\DepartmentRepository;

class DepartmentController extends Controller
{
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index()
    {
        $total_departments = $this->departmentRepository->count();
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
                $exists = $this->departmentRepository->exists($code, $name);

                if ($exists) {
                    return response()->json(['error' => 'Department code ' . $code . ' or name ' . $name . ' already exists']);
                } else {

                    $created_by = Helper::getLoggedInUserId();
                    $data = [
                        'code' => $code,
                        'name' => $name,
                        'created_by' => $created_by
                    ];

                    if ($this->departmentRepository->create($data)) {
                        $message = "Department " . $name . " has been added successfully";
                        $stats = $this->GetDepartmentStats();
                        $data = [
                            'success' => $message,
                            'data' => $stats,
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

    private function sendJson($id)
    {
        try {
            $data = Department::find($id);
            return response()->json(['success' => 'Ok', 'data' => $data]);
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
        return $this->sendJson($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->sendJson($id);
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
        if (!empty($id)) {

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
                    $exists = $this->departmentRepository->existsonUpdate($id, $code, $name);

                    if ($exists) {
                        return response()->json(['error' => 'Department code ' . $code . ' or name ' . $name . ' already exists']);
                    } else {

                        $data = [
                            'code' => $code,
                            'name' => $name,
                        ];

                        if ($this->departmentRepository->update($id, $data)) {
                            $message = "Department " . $name . " has been updated successfully";
                            $stats = $this->GetDepartmentStats();
                            $data = [
                                'success' => $message,
                                'data' => $stats
                            ];
                        } else {
                            $message = "Technical error in updating department";
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
        } else {
            return response()->json(['error' => 'System is unable to get department id']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!empty($id)) {

            try {

                $department = $this->departmentRepository->get($id);
                $data = [
                    'is_deleted' => !$department->is_deleted
                ];

                if ($this->departmentRepository->update($id, $data)) {
                    $message = "Department " . $department->name . " has been deleted successfully";
                    $stats = $this->GetDepartmentStats();
                    $data = [
                        'success' => $message,
                        'data' => $stats
                    ];
                    
                } else {
                    $message = "Technical error in deleting department";
                    $data = [
                        'error' => $message
                    ];
                }
                return response()->json($data);
            } catch (\Exception $ex) {
                return response()->json(['error' => $ex->getMessage()]);
            }
        } else {
            return response()->json(['error' => 'System is unable to get department id']);
        }
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
