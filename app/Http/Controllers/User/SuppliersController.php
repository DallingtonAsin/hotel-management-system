<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Supplier;
use App\Imports\ImportSuppliers;
use App\Exports\ExportSuppliers;
use App\DataTables\User\SuppliersDataTable;
use Illuminate\Support\Str;
use App\Helpers\Constants as Constant;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class SuppliersController extends Controller
{


    public $controller;
    public function __construct()
    {
        $this->controller = 'SuppliersController';
    }



    public function GetSuppliers(SuppliersDataTable $dataTable)
    {
        return $dataTable->render('pages.main.suppliers.index');
    }

    public function index()
    {
        try {

            $arr = $this->GetSumupDetails();
            $number_of_suppliers = $arr['totl_no'];
            $total_credit = $arr['totl_credit'];
            $total_debts = $arr['totl_debt'];

            return view('pages.main.suppliers.index')->with([
                'number_of_suppliers' => $number_of_suppliers,
                'total_credit' => $total_credit,
                'total_debts' => $total_debts,

            ]);
        } catch (ModelNotFoundException $ex) {
            throw new ModelNotFoundException("Not found what you are looking for");
        } catch (\Exception $ex) {
            return abort("405", "We have caught exception " . $ex->getMessage() . " for you");
        }
    }

    protected function GetSumupDetails()
    {
        $number_of_suppliers = Supplier::count();
        $total_credit = DB::table('suppliers')->sum('credit');
        $total_debts = DB::table('suppliers')->sum('debt');
        $data = array(
            'totl_no' => $number_of_suppliers,
            'totl_credit' => $total_credit,
            'totl_debt' => $total_debts
        );

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.main.suppliers.index');
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
            'name' => 'required',
            'tin' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'email' => 'sometimes|nullable',
            'credit' => 'sometimes|nullable',
            'debt' => 'sometimes|nullable',
        ]);

        try {
            if ($validator->fails()) {

                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $supplier_id = $request->input('id');
                $supplier_name = $request->input('name');
                $address = $request->input('address');
                $tin = $request->input('tin');
                $phone_number = $request->input('contact');
                $email = $request->input('email');
                $credit = $request->input('credit');
                $debt = $request->input('debt');

                if ($request->filled('credit')) {
                    $credit = Helper::Numberize($request->input('credit'));
                }
                if ($request->filled('debt')) {
                    $debt = Helper::Numberize($request->input('debt'));
                }

                empty($supplier_id) ? $keyAction = 'registered' : $keyAction = 'updated';

                if (!empty($supplier_id)) {

                    $response = Supplier::where('id', $supplier_id)
                        ->update([
                            'name' => $supplier_name,
                            'phone_number' => $phone_number,
                            'tin' => $tin,
                            'address' => $address,
                            'email' => $email,
                            'debt' => $debt,
                            'credit' => $credit,
                        ]);
                } else {

                    $supplier = [
                        'name' => $supplier_name,
                        'tin' => $tin,
                        'phone_number' => $phone_number,
                        'email' => $email,
                        'address' => $address,
                        'debt' => $debt,
                        'credit' => $credit,
                        'created_by' => Auth::user()->id,
                    ];
                    $response = Supplier::create($supplier);
                }

                if ($response) {

                    $action = "" . $keyAction . " supplier " . $supplier_name . "";
                    Helper::logger($request, $action, now());
                    $dataArr = array(
                        "code" => '200',
                        "message" => $action,
                        "method" => "SuppliersController@store"
                    );
                    Helper::LogRequest($request, $dataArr);

                    $message = Helper::ActionMessage($action);
                    $arr = $this->GetSumupDetails();

                    return response()->json([
                        'success' => $message,
                        'totl_no' => $arr['totl_no'],
                        'totl_credit' => $arr['totl_credit'],
                        'totl_debt' => $arr['totl_debt'],
                    ]);
                } else {

                    $messageErr = "registering of supplier details not failed!";
                    $dataArr = array(
                        "code" => '101',
                        "message" => $messageErr,
                        "method" => "SuppliersController@store"
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

    private function getSupplerDetails($id)
    {
        try {

            $supplier = Supplier::find($id);
            return response()->json(['success' => 'Ok', 'data' =>  $supplier]);
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
        return $this->getSupplerDetails($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->getSupplerDetails($id);
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
            'name' => 'required',
            'tin' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'email' => 'sometimes|nullable',
            'credit' => 'sometimes|nullable',
            'debt' => 'sometimes|nullable',
        ]);

        $supplier = Supplier::find($id);

        $supplier->name = $supplier_name = $request->input('name');
        $supplier->address = $request->input('address');
        $supplier->tin = $request->input('tin');
        $supplier->phone_number = $request->input('contact');
        $email = $request->input('email');
        $debt = Helper::Numberize($request->input('debt'));
        $credit = Helper::Numberize($request->input('credit'));

        empty($email) ? $supplier->email = "" : $supplier->email = $email;
        empty($debt) ? $supplier->debt = 0 : $supplier->debt = $debt;
        empty($credit) ? $supplier->credit = 0 : $supplier->credit = $credit;

        $save_status = $supplier->save();

        if ($save_status) {

            $action = "updated details of supplier " . $supplier_name . "";
            Helper::logger($request, $action, now());
            $dataArr = array(
                "code" => '200',
                "message" => $action,
                "method" => "SuppliersController@update"
            );
            Helper::LogRequest($request, $dataArr);

            return back()->with("success", Helper::ActionMessage($action));
        } else {
            $messageErr = "supplier details not updated!";
            $dataArr = array(
                "code" => '101',
                "message" => $messageErr,
                "method" => "SuppliersController@update"
            );
            Helper::LogRequest($request, $dataArr);
            return back()->with('fail', $messageErr);
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

                $method = "SuppliersController@destroy";

                $supplier = Supplier::find(intval($id)); 
                $response = $supplier->update(['is_deleted' => true]);

                if ($response) {
                    
                    $action = "removed supplier " . $supplier->name . " from the system";
                    Helper::logger($request, $action, now());
                    $dataArr = array(
                        "code" => '200',
                        "message" => $action,
                        "method" => $method
                    );
                    Helper::LogRequest($request, $dataArr);
                    $message = Helper::ActionMessage($action);
                    $arr = $this->GetSumupDetails();

                    return response()
                        ->json(['success' => $message,
                                'data' => $arr,
                               ]);

                } else {

                    $messageErr = "supplier not removed";
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
    }


    public function deleteAllSuppliers(Request $request)
    {
        $result = Supplier::truncate();
        if ($result) {

            $action = "deleted all suppliers from the system";
            Helper::logger($request, $action, now());
            $dataArr = array(
                "code" => '200',
                "message" => $action,
                "method" => "SuppliersController@deleteAllSuppliers"
            );
            Helper::LogRequest($request, $dataArr);
            $sessionVariable = 'success';
            $responseInfo = Helper::ActionMessage($action);
            //  return back()->with("success", Helper::ActionMessage($action));
        } else {
            $messageErr = "suppliers not removed from the system!";
            $dataArr = array(
                "code" => '101',
                "message" => $messageErr,
                "method" => "SuppliersController@deleteAllSuppliers"
            );
            Helper::LogRequest($request, $dataArr);
            $sessionVariable = 'error';
            $responseInfo = $messageErr;
            // return back()->with('fail', $messageErr);
        }

        $arr = $this->GetSumupDetails();

        return response()
            ->json([
                $sessionVariable => $responseInfo,
                'totl_no' => $arr['totl_no'],
                'totl_credit' => $arr['totl_credit'],
                'totl_debt' => $arr['totl_debt'],
            ]);
    }

    public function importSuppliers(Request $request)
    {

        $this->validate(
            $request,
            ['select_file' => 'required|mimes:xls,xlsx'],
            ['select_file.mimes' => 'Please select only excel files to import suppliers']
        );

        $importSuccess = Excel::import(new ImportSuppliers, request()->file('select_file'));

        if ($importSuccess) {

            $action = "imported an excel file of suppliers into the system";
            Helper::logger($request, $action, now());
            $dataArr = array(
                "code" => '200',
                "message" => $action,
                "method" => "SuppliersController@importSuppliers"
            );
            Helper::LogRequest($request, $dataArr);
            return back()->with('success', Helper::ActionMessage($action));
        } else {
            $messageErr = "Excel suppliers data not imported!";
            $dataArr = array(
                "code" => '101',
                "message" => $messageErr,
                "method" => "SuppliersController@importSuppliers"
            );
            Helper::LogRequest($request, $dataArr);
            return back()->with('fail', $messageErr);
        }
    }


    public function RemoveSelected(Request $request)
    {
        try {
            $ids =  $request->input('selected_rows');
            $DeletedSuppliers = array();

            if (count($ids) > 0) {
                foreach ($ids as $id) {
                    $findId = Supplier::find($id);
                    $findId->delete();
                    array_push($DeletedSuppliers, $findId->name);
                }
            }
            $sessionVariable = 'success';
            $deletedSuppliersStr = implode(", ", $DeletedSuppliers);
            $action = "removed suppliers " . $deletedSuppliersStr . " from the system";
            if (count($ids) == 1) {
                $action = Str::replaceFirst('suppliers', 'supplier', $action);
            }
            $response = Helper::ActionMessage($action);

            $dataArr = array(
                "code" => '200',
                "message" => $action,
                "method" => "SuppliersController@RemoveSelected"
            );
            Helper::logger($request, $action, now());
            Helper::LogRequest($request, $dataArr);

            $arr = $this->GetSumupDetails();

            $arr = $this->GetSumupDetails();

            return response()
                ->json([
                    $sessionVariable => $response,
                    'totl_no' => $arr['totl_no'],
                    'totl_credit' => $arr['totl_credit'],
                    'totl_debt' => $arr['totl_debt'],
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


    /**
     * @return \Illuminate\Support\Collection
     */
    public function exportSuppliers()
    {
        return Excel::download(new ExportSuppliers, 'suppliers.xlsx');
    }




    protected function SuccessMessage($msg)
    {
        $message = "You have successfully " . $msg . "";
        return $message;
    }


    protected function FailedMessage($failmsg)
    {
        $message = "" . $failmsg . "";
        return $message;
    }

    public function getSupplierDetailsAjax(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $supplier = Supplier::find($id);
                return response()->json(['success' => 'Ok', 'data' => $supplier]);
            }else{
              return response()->json(['error' => 'Request rejected: unknown request type']);
            }
        } catch (\Exception $ex) {
          return response()->json(['error' => $ex->getMessage()]);
        }
    }
}
