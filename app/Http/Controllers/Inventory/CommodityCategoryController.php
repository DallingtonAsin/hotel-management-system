<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Inventory\CommodityCategoriesDataTable;
use App\Repositories\CommodityCategoryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;


class CommodityCategoryController extends Controller
{

    protected $commodityCategoryRepository;
    public function __construct(CommodityCategoryRepository $commodityCategoryRepository)
    {
        $this->commodityCategoryRepository = $commodityCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $number_of_categories = $this->commodityCategoryRepository->count();
        return view('pages.main.inventory.goods.categories')->with(compact('number_of_categories'));
    }

    public function getCommoditiesDataTable(CommodityCategoriesDataTable $dataTable)
    {
      return $dataTable->render('pages.main.inventory.goods.categories');
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
            'category_code' => 'required'
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $method = "CommodityCategoryController@store";

                $category_name = $request->input('category_name');
                $category_code = $request->input('category_code');

                if ($this->commodityCategoryRepository->existsCommodityCategory($category_code, $category_name)) {
                    return response()->json(['error' => 'Commodity category with code ' . $category_code . ' or name '.$category_name.' already exists']);
                } else {

                    $expense_type = [
                        'name' => $category_name,
                        'code' => $category_code,
                        'created_by' => Auth::user()->id,
                    ];

                    if ($this->commodityCategoryRepository->create($expense_type)) {
                        $action = "added commodity category " . $category_name . "";

                        Helper::logger($request, $action, now());
                        $dataArr = ["code" => '200', "message" => $action, "method" => $method];
                        Helper::LogRequest($request, $dataArr);

                        $message = Helper::ActionMessage($action);
                        $arr['total'] = $this->commodityCategoryRepository->count();

                        return response()->json(['success' => $message,  'data' => $arr]);
                    } else {

                        $messageErr = 'System has failed to add commodity category';
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

    private function getCommodityCatDetails($id){
        try {

            $commodity_category = $this->commodityCategoryRepository->get($id);
            return response()->json(['success' => 'Ok', 'data' => $commodity_category]);
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
        return $this->getCommodityCatDetails($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->getCommodityCatDetails($id);
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
            'category_code' => 'required'
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $method = "CommodityCategoryController@store";

                $category_name = $request->input('category_name');
                $category_code = $request->input('category_code');

                if ($this->commodityCategoryRepository->checkCommodityCategoryonUpdate($category_code, $category_name)) {
                    return response()->json(['error' => 'Commodity category with code ' . $category_code . ' or name '.$category_name.' already exists']);
                } else {

                    $expense_type = [
                        'name' => $category_name,
                        'code' => $category_code,
                    ];

                    if ($this->commodityCategoryRepository->update($id, $expense_type)) {
                        $action = "updated commodity category " . $category_name . "";

                        Helper::logger($request, $action, now());
                        $dataArr = ["code" => '200', "message" => $action, "method" => $method];
                        Helper::LogRequest($request, $dataArr);

                        $message = Helper::ActionMessage($action);
                        $arr['total'] = $this->commodityCategoryRepository->count();

                        return response()->json(['success' => $message,  'data' => $arr]);
                    } else {

                        $messageErr = 'System has failed to update commodity category';
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
    }else{
        return response()->json(['error' => 'System unable to get commodity category id']);
    }
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

    public function findCommodityCategoryAjax(Request $request, $id){
      if($id){
        if($request->ajax()){
            $category = $this->commodityCategoryRepository->get($id);
            return response()->json(['success' => 'Ok', 'data' => $category]);
        }else{
        return response()->json(['error' => 'Unknown request type']);
        }
      }else{
        return response()->json(['error' => 'System unable to get commodity category id']);
      }
    }
}
