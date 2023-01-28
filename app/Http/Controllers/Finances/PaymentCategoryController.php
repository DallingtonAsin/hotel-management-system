<?php

namespace App\Http\Controllers\Finances;

use App\DataTables\Finances\PaymentCategoriesDataTable;
use App\Repositories\PaymentCategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class PaymentCategoryController extends Controller
{

    protected $paymentCategoryRepository;

    public function __construct(PaymentCategoryRepository $paymentCategoryRepository)
    {
         $this->paymentCategoryRepository = $paymentCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_categories = $this->paymentCategoryRepository->count();
        return view('pages.main.hr.finances.payment_categories')->with(compact('total_categories'));
    }


    public function getPaymentCategoriesDataTable(PaymentCategoriesDataTable $datatable){
        return $datatable->render('pages.main.hr.finances.payment_categories');
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
            'category_name' => 'required',
            'transaction_type' => 'required'
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $method = "PaymentCategoryController@store";

                $category_name = $request->input('category_name');
                $transaction_type = $request->input('transaction_type');

                if ($this->paymentCategoryRepository->existsPaymentCategory($category_name)) {
                    return response()->json(['error' => 'Payment category with code ' . $category_name . ' already exists']);
                } else {

                    $payment_category = [
                        'name' => $category_name,
                        'transaction_type' => $transaction_type,
                        'created_by' => Auth::user()->id,
                    ];

                    if ($this->paymentCategoryRepository->create($payment_category)) {
                        $action = "added payment category " . $category_name . "";

                        Helper::logger($request, $action, now());
                        $dataArr = ["code" => '200', "message" => $action, "method" => $method];
                        Helper::LogRequest($request, $dataArr);

                        $message = Helper::ActionMessage($action);
                        $arr['total'] = $this->paymentCategoryRepository->count();

                        return response()->json(['success' => $message,  'data' => $arr]);
                    } else {

                        $error = 'System has failed to add payment category';
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

    private function getPaymentCategoryDetails($id){
        try {

            $payment_category = $this->paymentCategoryRepository->get($id);
            return response()->json(['success' => 'Ok', 'data' => $payment_category]);
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
        return $this->getPaymentCategoryDetails($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->getPaymentCategoryDetails($id);
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
        if($id){

            $validator = Validator::make($request->all(), [
                'category_name' => 'required',
                'transaction_type' => 'required'
            ]);
    
            try {
                if ($validator->fails()) {
                    $message = $validator->errors()->all();
                    return response()->json(['error' => $message]);
                } else {
    
                    $method = "PaymentCategoryController@update";
    
                    $category_name = $request->input('category_name');
                    $transaction_type = $request->input('transaction_type');
    
                    if ($this->paymentCategoryRepository->checkPaymentCategoryonUpdate($id, $category_name)) {
                        return response()->json(['error' => 'Payment category with name '.$category_name.' already exists']);
                    } else {
    
                        $expense_type = [
                            'name' => $category_name,
                            'transaction_type' => $transaction_type,
                        ];
    
                        if ($this->paymentCategoryRepository->update($id, $expense_type)) {
                            $action = "updated payment category " . $category_name . "";
    
                            Helper::logger($request, $action, now());
                            $dataArr = ["code" => '200', "message" => $action, "method" => $method];
                            Helper::LogRequest($request, $dataArr);
    
                            $message = Helper::ActionMessage($action);
                            $arr['total'] = $this->paymentCategoryRepository->count();
    
                            return response()->json(['success' => $message,  'data' => $arr]);
                        } else {
    
                            $error = 'System has failed to update payment category';
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
            return response()->json(['error' => 'System unable to get payment category id']);
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

              $method = "PaymentCategoryController@destroy";
              $category = $this->paymentCategoryRepository->get($id);
              $action =  $category->is_deleted ? 'undeleted' : 'deleted';

              if ($this->paymentCategoryRepository->update($id, ['is_deleted' => !$category->is_deleted])) {

                $name = $category->name;
      
                $action = $action." payment category " . $name . "";
                Helper::logger($request, $action, now());
                $dataArr = ["code" => '200', "message" => $action, "method" => $method];
      
                Helper::LogRequest($request, $dataArr);
                $message = Helper::ActionMessage($action);
                $arr['total'] = $this->paymentCategoryRepository->count();

                return response()
                  ->json([
                    'success' => $message,
                    'data' => $arr,
                  ]);

              } else {
      
                $error = 'System unable to delete payment category';
                $dataArr = ["code" => '200', "message" => $error, "method" => $method];
                Helper::LogRequest($request, $dataArr);
                $message = Helper::FailedMessage($error);

                return response()->json(['error' => $message]);
              }
            } catch (\Exception $ex) {
              return response()->json(['error' => $ex->getMessage()]);
            }
          } else {
            return response()->json(['error' => 'System is unable to get payment category id']);
          }
    }
}
