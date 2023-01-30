<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Inventory\GoodsDataTable;
use App\Services\Api\GoodsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CommodityCategoryRepository;
use App\Repositories\GoodsRepository;
use App\Helpers\Helper;
use App\Repositories\CurrencyRepository;


class GoodsController extends Controller
{

    protected $goodsService, $goodsRepository, $goodsCategoryRepository;
    protected $currencyRepository;

    public function __construct(
        GoodsService $goodsService,
        GoodsRepository $goodsRepository,
        CurrencyRepository $currencyRepository,
        CommodityCategoryRepository $goodsCategoryRepository
    ) {
        $this->goodsService = $goodsService;
        $this->goodsRepository = $goodsRepository;
        $this->currencyRepository = $currencyRepository;
        $this->goodsCategoryRepository = $goodsCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $number_of_goods = $this->goodsRepository->count();
        $currencies = $this->currencyRepository->get();
        $commodity_categories = $this->goodsCategoryRepository->get();
        // $currencies
        return view('pages.main.inventory.goods.index')->with(compact('commodity_categories', 'number_of_goods', 'currencies'));
    }

    public function getsGoodsDataTable(GoodsDataTable $dataTable)
    {
        return $dataTable->render('pages.main.inventory.goods.index');
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
            'goods_name' => 'required',
            'goods_code' => 'required',
            'measure_unit' => 'required',
            'unit_price' => 'required',
            'currency' => 'required',
            'commodity_category' => 'required',
            'stock_prewarning' => 'required',
            'have_excise_tax' => 'required',
            'have_piece_unit' => 'required',
            'have_other_unit' => 'required'
        ]);

        try {
            if ($validator->fails()) {

                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $goods_code = $request->input('goods_code');
                $exists_good = $this->goodsRepository->existsGood($goods_code);

                if ($exists_good) {
                    return response()->json(['error' => 'Good with code ' . $goods_code . ' already exists in the system']);
                } else {

                    $method = "GoodsController@store";

                    $goods_name = $request->input('goods_name');
                    $goods_code = $request->input('goods_code');

                    $measure_unit = $request->input('measure_unit');
                    $currency_id = $request->input('currency');
                    $unit_price = Helper::Numberize($request->input('unit_price'));
                    $stock_prewarning = Helper::Numberize($request->input('stock_prewarning'));
                    $commodity_category_id  = $request->input('commodity_category');
                    $have_excise_tax = $request->input('have_excise_tax');
                    $have_piece_unit = $request->input('have_piece_unit');
                    $have_other_unit = $request->input('have_other_unit');

                    $currency = $this->currencyRepository->get($currency_id);
                    $commodity_category = $this->goodsCategoryRepository->get($commodity_category_id);


                    $efris_goods_data = [
                        'goodsName' => $goods_name,
                        'goodsCode' => $goods_code,
                        'measureUnit' => $measure_unit,
                        'unitPrice' => $unit_price,
                        'currency' => $currency->efris_code,
                        'commodityCategoryId' => $commodity_category->code,
                        'stockPrewarning' => $stock_prewarning,
                        'haveExciseTax' => $have_excise_tax,
                        'havePieceUnit' => $have_piece_unit,
                        'haveOtherUnit' => $have_other_unit,
                    ];

                    $apiResponse = $this->goodsService->addGood($efris_goods_data);
                    $apiResponse = json_decode(json_encode($apiResponse->getData()), true);

                    if ($apiResponse['statusCode'] ==  200) {

                        $good = [
                            'goods_name' => $goods_name,
                            'goods_code' => $goods_code,
                            'measure_unit' => $measure_unit,
                            'unit_price' => $unit_price,
                            'currency_id' => $currency->id,
                            'commodity_category_id' => $commodity_category->id,
                            'stock_prewarning' => $stock_prewarning,
                            'have_excise_tax' => $have_excise_tax,
                            'have_piece_unit' => $have_piece_unit,
                            'have_other_unit' => $have_other_unit,
                            'created_by' => Auth::user()->id,
                        ];

                        if ($this->goodsRepository->create($good)) {

                            $action = "recorded good " . $goods_name . " in the system";
                            Helper::logger($request, $action, now());
                            $dataArr = array(
                                "code" => '200',
                                "message" => $action,
                                "method" => $method
                            );

                            Helper::LogRequest($request, $dataArr);

                            $message = Helper::ActionMessage($action);
                            $arr['total'] = $this->goodsRepository->count();

                            return response()
                                ->json([
                                    'success' => $message,
                                    'data' => $arr
                                ]);
                        } else {

                            $error = "System has failed to add good";

                            $dataArr = array(
                                "code" => '101',
                                "message" => $error,
                                "method" => $method
                            );

                            Helper::LogRequest($request, $dataArr);
                            $message = Helper::FailedMessage($error);
                            return response()->json(['error' => $message]);
                        }
                    } else {
                        return response()->json(['error' => $apiResponse['message']]);
                    }
                }
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => 'System unable to upload good on EFRIS because of' . $ex->getMessage()]);
        }
    }


    private function getGoodDetails($id){
        try{
            $good = $this->goodsRepository->get($id);
            $good->commodity_category_code = $this->goodsCategoryRepository->get($good->commodity_category_id)->code;
            return response(['success' => 'OK', 'data' => $good]);
        }catch(\Exception $ex){
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
        return $this->getGoodDetails($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->getGoodDetails($id);
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


    public function getSearchGoodsAjax(Request $request)
    {
        try {
            if ($request->ajax()) {
                if ($request->input('query')) {
                  

                    $query = $request->input('query');
                    $data = array();
                    $goods = $this->goodsRepository->getGoodsByName($query);
        
                    foreach ($goods as $good) {
                        $data[] = $good->goods_name;
                        $data[] = $good->goods_code;
                    }
                    echo json_encode($data);
                } else {
                    return response()->json(['error' => 'Unknown request type']);
                }
            } else {
                return response()->json(['error' => 'System unable to get search name']);
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function searchGoodDetails(Request $request, $goods_name){
        try {
            if ($request->ajax()) {
                
                    $good = $this->goodsRepository->findGoodByName($goods_name);
                    return response()->json(['success' => 'Ok', 'data' => $good]);
        
            } else {
                return response()->json(['error' => 'System unable to get search name']);
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }


}
