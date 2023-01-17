<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffPermission;
use App\DataTables\HR\StaffPermissionsDataTable;
use App\Models\Permission;
use App\Staff;
use Illuminate\Support\Facades\Validator;


class StaffPermissionController extends Controller
{


    public function index()
    {
        $total_permissions = StaffPermission::count();
        return view('pages.main.hr.permissions.index', ['total_permissions' => $total_permissions]);
    }

    public function getStaffPermissions(StaffPermissionsDataTable $dataTable)
    {
        return $dataTable->render('pages.main.hr.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $permissions = Permission::all();
            $staff_members =  Staff::select('id', 'first_name', 'last_name')->get();
            return view('pages.main.hr.permissions.assign')->with(compact('permissions', 'staff_members'));
        } catch (\Exception $ex) {
            throw $ex;
        }
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
            'staff_id' => 'required',
            'permissions' => 'required|array|exists:permissions,id',
        ], [
            'staff_id.required' => 'Please select staff member.',
            'permissions.required' => 'Please select at least one permission.',
            'permissions.array' => 'Permissions must be an array.',
            'permissions.exists' => 'Invalid permission selected.',
        ]);

        try {
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $staff_id = $request->input('staff_id');
                $staff = Staff::find($staff_id);
                $staff_names = $staff->first_name . ' ' . $staff->last_name;
                $permissions = $request->input('permissions');
                $staff->permissions()->sync($permissions);
                $staff->permissions()->updateExistingPivot($permissions, ['active' => 1]);

                return back()->with('success', 'Permissions for staff member ' . $staff_names . ' have been recorded successfully');
            }
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
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
         $staff = Staff::find($id);
         $permissions = Permission::all();
         return view('pages.main.hr.permissions.edit', compact('staff', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        $permissions = $request->input('permissions');
        $staff_name = $staff->first_name. ' '.$staff->last_name;
        $staff->syncPermissions($permissions);
        return redirect()->back()->with('success', 'Permissions for '.$staff_name.' have been updated successfully');
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
