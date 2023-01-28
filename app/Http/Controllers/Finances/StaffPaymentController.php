<?php

namespace App\Http\Controllers\Finances;

use App\DataTables\Finances\StaffPaymentsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\StaffPaymentRepository;
use App\Repositories\StaffRepository;
use App\Repositories\PaymentCategoryRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;
use PDF;


class StaffPaymentController extends Controller
{

    protected $staffRepository, $staffPaymentRepository, $paymentCategoryRepository;

    public function __construct(StaffPaymentRepository $staffPaymentRepository, StaffRepository $staffRepository, PaymentCategoryRepository $paymentCategoryRepository)
    {
        $this->staffPaymentRepository = $staffPaymentRepository;
        $this->staffRepository = $staffRepository;
        $this->paymentCategoryRepository= $paymentCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_payments = $this->staffPaymentRepository->count();
        $staff = $this->staffRepository->get();
        $payment_categories = $this->paymentCategoryRepository->get();

        return view('pages.main.hr.finances.staff_payments')
        ->with(compact('total_payments', 'staff', 'payment_categories'));
    }

    public function getStaffPaymentsDataTable(StaffPaymentsDataTable $datatable){
        return $datatable->render('pages.main.hr.finances.staff_payments');
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
            'staff_id' => 'required',
            'category_id' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $method = "StaffPaymentController@store";

                $staff_id = $request->input('staff_id');
                $category_id = $request->input('category_id');
                $payment_date = $request->input('payment_date');
                $record = $this->getPaymentRecordDetails($staff_id, $category_id);


                if ($this->staffPaymentRepository->checkIfPaymentExists($staff_id, $category_id, $payment_date)) {
                    return response()->json(['error' => ' '.$record['category_name'].' payment for '.$record['staff_name'].' on date '.$payment_date.' already exists']);
                } else {

                    $amount = $request->input('amount');
                    $amount = Helper::Numberize($amount);

                    $paymentData = [
                        'staff_id' => $staff_id,
                        'payment_category_id' => $category_id,
                        'amount' => $amount,
                        'payment_date' => $payment_date,
                        'created_by' => Auth::user()->id,
                    ];

                    if ($this->staffPaymentRepository->create($paymentData)) {
                        $action = "added payment of type " . $record['category_name'] . " for ".$record['staff_name']."";

                        Helper::logger($request, $action, now());
                        $dataArr = ["code" => '200', "message" => $action, "method" => $method];
                        Helper::LogRequest($request, $dataArr);

                        $message = Helper::ActionMessage($action);
                        $arr['total'] = $this->staffPaymentRepository->count();

                        return response()->json(['success' => $message,  'data' => $arr]);
                    } else {

                        $error = 'System has failed to add payment';
                        $dataArr = ["code" => '101', "message" => $error,  "method" => $method];

                        Helper::LogRequest($request, $dataArr);
                        $message = Helper::FailedMessage($error);

                        return response()->json(['error' => $message]);
                    }
                }
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    private function getPaymentDetails($id){
        try {

            $payment = $this->staffPaymentRepository->get($id);
            $staff = $this->staffRepository->get($payment->staff_id);
            $payment->staff_name = $staff->first_name . ' '. $staff->last_name;
            return response()->json(['success' => 'Ok', 'data' => $payment]);
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
        return $this->getPaymentDetails($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->getPaymentDetails($id);
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
       if(!empty($id)){
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'category_id' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $method = "StaffPaymentController@store";

                $staff_id = $request->input('staff_id');
                $category_id = $request->input('category_id');
                $payment_date = $request->input('payment_date');
                $record = $this->getPaymentRecordDetails($staff_id, $category_id);


                if ($this->staffPaymentRepository->checkIfPaymentExistsonUpdate($id, $staff_id, $category_id, $payment_date)) {
                    return response()->json(['error' => ' '.$record['category_name'].' payment for '.$record['staff_name'].' on date '.$payment_date.' already exists']);
                } else {

                    $amount = $request->input('amount');
                    $amount = Helper::Numberize($amount);

                    $paymentData = [
                        'staff_id' => $staff_id,
                        'payment_category_id' => $category_id,
                        'amount' => $amount,
                        'payment_date' => $payment_date,
                        'created_by' => Auth::user()->id,
                    ];

                    if ($this->staffPaymentRepository->update($id, $paymentData)) {
                        $action = "updated payment of type " . $record['category_name'] . " for ".$record['staff_name']."";

                        Helper::logger($request, $action, now());
                        $dataArr = ["code" => '200', "message" => $action, "method" => $method];
                        Helper::LogRequest($request, $dataArr);

                        $message = Helper::ActionMessage($action);
                        $arr['total'] = $this->staffPaymentRepository->count();

                        return response()->json(['success' => $message,  'data' => $arr]);
                    } else {

                        $error = 'System has failed to update payment';
                        $dataArr = ["code" => '101', "message" => $error,  "method" => $method];

                        Helper::LogRequest($request, $dataArr);
                        $message = Helper::FailedMessage($error);

                        return response()->json(['error' => $message]);
                    }
                }
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
       }else{
        return response()->json(['error' => 'System unable to get payment id']);
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

              $method = "StaffPaymentController@destroy";
              $payment = $this->staffPaymentRepository->get($id);
              $action =  $payment->is_deleted ? 'undeleted' : 'deleted';

              if ($this->staffPaymentRepository->update($id, ['is_deleted' => !$payment->is_deleted])) {

                $record = $this->getPaymentRecordDetails($payment->staff_id, $payment->payment_category_id);
                $payment_category = $record['category_name'];
                $staff_name = $record['staff_name'];

                $action = $action." payment of category ".$payment_category." for " . $staff_name . "";
                Helper::logger($request, $action, now());
                $dataArr = ["code" => '200', "message" => $action, "method" => $method];
      
                Helper::LogRequest($request, $dataArr);
                $message = Helper::ActionMessage($action);
                $arr['total'] = $this->staffPaymentRepository->count();

                return response()
                  ->json([
                    'success' => $message,
                    'data' => $arr,
                  ]);

              } else {
      
                $error = 'System unable to delete payment';
                $dataArr = ["code" => '200', "message" => $error, "method" => $method];
                Helper::LogRequest($request, $dataArr);
                $message = Helper::FailedMessage($error);

                return response()->json(['error' => $message]);
              }
            } catch (\Exception $ex) {
              return response()->json(['error' => $ex->getMessage()]);
            }
          } else {
            return response()->json(['error' => 'System is unable to get payment id']);
          }
    }

    private function getPaymentRecordDetails($staff_id, $category_id){
        try{

            $staff = $this->staffRepository->get($staff_id);
            $category = $this->paymentCategoryRepository->get($category_id);
            $staff_name = $staff->first_name . ' '. $staff->last_name;

            return [
                'staff_name' => $staff_name,
                'category_name' => $category->name
            ];

        }catch(\Exception $ex){
            throw $ex;
        }
    }

 /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generatePaymentSlip(Request $request, $payment_id){

        $directory = 'payments/slips';
        Helper::createInvoicesDirIfnotExists(($directory));
        $filename = 'invoice-000.pdf';
        $path = public_path('' . $directory . '/' . $filename);

        // return view('pages.main.invoices.payment_slip');
        $pdf = PDF::loadView('pages.main.invoices.payment_slip', []);
        $pdf->save($path);
        $subpath = '' . $directory . '/' . $filename;
        $url = Storage::disk('invoices')->url($subpath);
        return response()->json(['url' => $url]);
    }


}
