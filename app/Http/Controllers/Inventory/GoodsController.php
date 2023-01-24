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


class GoodsController extends Controller
{

    protected $goodsService, $goodsRepository, $goodsCategoryRepository;
    public function __construct(GoodsService $goodsService, GoodsRepository $goodsRepository, CommodityCategoryRepository $goodsCategoryRepository)
    {
        $this->goodsService = $goodsService;
        $this->goodsRepository = $goodsRepository;
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
        $commodity_categories = $this->goodsCategoryRepository->get();
        return view('pages.main.inventory.goods.index')->with(compact('commodity_categories', 'number_of_goods'));
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
            'goods_code' => 'required',
            'goods_name' => 'required',
            'measure_unit' => 'required',
            'unit_price' => 'required',
            'currency' => 'sometimes|nullable',
            'commodity_category_id' => 'required',
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
                    $measure_unit = $request->input('measure_unit');
                    $currency_code = $request->input('currency_code');
                    $unit_price = Helper::Numberize($request->input('unit_price'));
                    $commodity_category_id  = $request->input('commodity_category_id');
                    $has_exercise_tax = $request->input('has_exercise_tax');
                    $have_piece_unit = $request->input('have_piece_unit');
                    $have_other_unit = $request->input('have_other_unit');

                    $efris_goods_data = [
                        'goodsName' => $goods_name,
                        'goodsCode' => $goods_code,
                        'measureUnit' => $measure_unit,
                        'unitPrice' => $unit_price,
                        'currency' => $currency_code,
                        'commodityCategoryId' => $commodity_category_id,
                        'haveExciseTax' => $has_exercise_tax,
                        'havePieceUnit' => $have_piece_unit,
                        'haveOtherUnit' => $have_other_unit,
                    ];

                    $apiResponse = $this->goodsService->addGood($efris_goods_data);
                    // dd($apiResponse);
                    if ($apiResponse['statusCode'] ==  200) {

                        $good = [
                            'goods_name' => $goods_name,
                            'goods_code' => $goods_code,
                            'measure_unit' => $measure_unit,
                            'unit_price' => $unit_price,
                            'currency' => $currency_code,
                            'commodity_category_id' => $commodity_category_id,
                            'have_excise_tax' => $has_exercise_tax,
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

                            $message = $this->ActionMessage($action);
                            $arr = $this->getStockStats();

                            return response()
                                ->json([
                                    'success' => $message,
                                    'data' => $arr
                                ]);
                        } else {

                            $messageErr = "System has failed to add good";

                            $dataArr = array(
                                "code" => '101',
                                "message" => $messageErr,
                                "method" => $method
                            );

                            Helper::LogRequest($request, $dataArr);
                            $message = $this->FailedMessage($messageErr);
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
}
