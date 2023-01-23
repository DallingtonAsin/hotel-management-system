<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Tax;
use App\Models\SalesTaxTracker;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\ReceiptGenerator;
use App\Helpers\Helper;
use Carbon\Carbon;

class SalesPointController extends Controller
{


    private $total_amount_of_sales = 0;
    private $sold_items = array();

    public function getProductItemDetails(Request $request)
    {

        if ($request->input('itemId')) {

            $itemId = $request->input('itemId');
            $isBarcode = $request->input('isBarcode');

            if ($isBarcode == 1) {
                $itemData = Stock::where('item_code', $itemId)->get();
            } else {
                $itemData = Stock::where('item_name', $itemId)->get();
            }
            return json_encode(array('data' => $itemData));
        }
    }


    protected function GetIndexOfArr($arr, $code)
    {
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i]["code"] == $code) {
                return $i;
            }
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.main.pos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.main.pos.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {

    } // end of method store

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
    public function update(Request $req, $id)
    {

    }

    public function MakeSaleGateway(Request $request)
    {
        $add2CartResponse = $this->GetSaleAndTransact($request);
        if ($add2CartResponse == true) {
            $response =  $this->recordSale($request);
        } else {
            $response = "Unable to insert sale details into cart";
        }
        return response()->json([
            'response' => $response
        ]);
    }

    public function recordSale(Request $req)
    {

        try {

            $method = "SalesPointController @recordSale";
            $data = $req->input('tabledata');
            $customer = $req->input('customer');
            $extra_money = $req->input('extra_money');
            $extra_money = (!empty($extra_money)) ? floatval($extra_money) : 0;
          
            $dataArr = json_decode($data, true);
            // dd($dataArr);

            if (is_array($dataArr) && count($dataArr) > 0) {

                foreach ($dataArr as $key) {

                    $item_code = $key['barcode'];
                    $item = $key['item'];
                    $this->sold_items[] = $item;
                    $quantity = floatval(str_replace(',', '', $key['quantity']));
                    $price = floatval(str_replace(',', '', $key['price']));
                    $sub_total = floatval(str_replace(',', '', $key['sub_total']));
                    $discount = floatval(str_replace(',', '', $key['discount']));
                    $total = floatval(str_replace(',', '', $key['total']));
                    $paid_amount = floatval(str_replace(',', '', $key['paid']));


                    $isCredit = filter_var($key['is_credit'], FILTER_VALIDATE_BOOLEAN);

                    if ($isCredit == true && $total == $paid_amount) {
                        $amount_paid = 0;
                        $balance = $paid_amount;
                    } else {
                        $amount_paid = $paid_amount;
                        $balance = $total - $paid_amount;
                    }

                    if ($isCredit == true) {
                        $is_credit = 1;
                        $fully_paid = 0;
                    } else {
                        $is_credit = 0;
                        $fully_paid = 1;
                    }

                    $date_of_sale = $key['date_of_sale'];

                    $arr = $this->getPrices($item);
                    $original_price = $arr['bprice'];
                    $this->total_amount_of_sales += floatval($sub_total);

                    // Get new quantity of item after sale
                    $qty_beforeSale = $this->getQtyBeforeSale($item);
                    $new_quantity = ($qty_beforeSale - $quantity);
                    $date = isset($date_of_sale) ? $date_of_sale : Carbon::now();

                    $taxAmount = $this->GetTax($total);
                    $cashier_id = Helper::getLoggedInUserId();
                    $item_id = Stock::where('item_name', $item)->first()->id;

                    $hasInsertedInSalesTbl = DB::table('sales')->insert([
                        'item_id' => $item_id,
                        'quantity' => $quantity,
                        'original_price' => $original_price,
                        'selling_price' => $price,
                        'discount' => $discount,
                        'amount' => $total,
                        'paid_amount' => $amount_paid,
                        'is_credit' => $is_credit,
                        'fully_paid' => $fully_paid,
                        'balance' => $balance,
                        'extra_money' => $extra_money,
                        'customer' => $customer,
                        'tax' => $taxAmount,
                        'date' => $date,
                        'cashier_id' => $cashier_id,
                    ]);

                    //If insertion is OK, reduce stock levels and clear cart
                    if ($hasInsertedInSalesTbl) {

                        $hasUpdatedStock = DB::table('stock')->where('item_name', $item)->update(['quantity' => $new_quantity]);
                        if ($hasUpdatedStock) {

                            $action = "recorded a sale of items " . json_encode($this->sold_items) . " at
                            " . number_format($this->total_amount_of_sales) . " ";
                            Helper::logger($req, $action, now());
                          
                            $dataArr = array(
                                "code" => '200',
                                "message" => $action,
                                "method" => $method
                            );
                            
                            Helper::LogRequest($req, $dataArr);
                            $message = $this->ActionMessage($action);
                            $type = 'success';

                        } else {

                            $message = "System has failed to update stock after transaction";
                            $dataArr = array(
                                "code" => '101',
                                "message" => $message,
                                "method" => $method
                            );
                            Helper::LogRequest($req, $dataArr);
                            $type = 'error';
                        }
                    } else {
                        $message = "System has failed to insert transaction in sales";
                        $dataArr = array(
                            "code" => '101',
                            "message" => $message,
                            "method" => $method
                        );
                        Helper::LogRequest($req, $dataArr);
                        $type = 'error';

                    }
                } // end of foreach

                return response()->json([$type => $message]);

            }
        } catch (\Exception $ex) {
            dd($ex);
            return response()->json(['error' => $ex->getMessage()]);
        }
    }




    public function getReceipt(ReceiptGenerator $rg)
    {
        try {
            $rg = new ReceiptGenerator();
            return $rg->generateReceipt();
        } catch (\Exception $ex) {
            throw $ex;
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

    }

    protected function getPrices($item)
    {

        $data = DB::select('select buying_price, selling_price
                            from stock where item_name = ? or item_code = ?', [$item, $item]);
        foreach ($data as $value) {
            $bprice = $value->buying_price;
            $sprice = $value->selling_price;
        }
        return array(
            "bprice" => $bprice,
            "sprice" => $sprice,
        );
    }

    private function getQtyBeforeSale($item)
    {
        $arr = $this->getListOfStockItemsData();
        $stockArr = $arr['items'];
        $stockIdArr = $arr['itemsIds'];

        if (in_array($item, $stockArr) || in_array($item, $stockIdArr)) {
                $data = Stock::where("item_code", "like", "%" . $item . "%")
                ->orWhere("item_name", "like", "%" . $item . "%")
                ->get();

            foreach ($data as $value) {
                $qty = $value->quantity;
            }
        } else {
            $qty = -1;
        }
        return $qty;
    }


    protected function getCartItems()
    {
        $items = DB::table('cart')->get();
        return $items;
    }



    public function ClearCart()
    {
        DB::table('cart')->truncate();
        return back();
    }

    protected function searchItem(Request $request)
    {

        if ($request->input('query')) {
            $query = $request->input('query');
            $data = array();
            $items = Stock::where("item_code", "like", "%" . $query . "%")
                ->orWhere("item_name", "like", "%" . $query . "%")
                ->get();

            foreach ($items as $item) {
                $data[] = $item->item_name;
                $data[] = $item->item_code;
            }
            echo json_encode($data);
            // return response()->json($data);
        }
    }

    protected function getItemPrice(Request $request)
    {
        if ($request->input('item')) {
            $query = $request->input('item');
            $data = array();
            $items = DB::table("stock")
                ->where("item_code", "like", "%" . $query . "%")
                ->orWhere("item_name", "like", "%" . $query . "%")
                ->get();
            foreach ($items as $item) {
                $data[] = $item->selling_price;
            }
            echo json_encode($data);
        }
    }

    protected function ActionMessage($action)
    {
        $message = "You have successfully " . $action . "";
        return $message;
    }

    protected function getListOfStockItemsData()
    {

        $items = DB::table('stock')->get();
        $itemsArr = $itemsIdArr = array();
        foreach ($items as $item) {
            array_push($itemsArr, $item->item_name);
            array_push($itemsIdArr, $item->item_code);
        }

        return array(
            'items' => $itemsArr,
            'itemsIds' => $itemsIdArr
        );
    }


    protected function GetItemRef($item)
    {
        $arr = $this->getListOfStockItemsData();
        $stockList = $arr['items'];
        $stockIdsList = $arr['itemsIds'];

        if (in_array($item, $stockList)) {
            $ref = DB::table("stock")
                ->where('item_name', $item)->value('item_code');
            $refId = 'name';
        } else if (in_array($item, $stockIdsList)) {
            $ref = DB::table("stock")
                ->where('item_code', $item)->value('item');
            $refId = 'id';
        } else {
            $ref = null;
            $refId = null;
        }

        $dataArr = array(
            "item" => $item,
            "ref" => $ref,
            "refId" => $refId,

        );

        return $dataArr;
    }


    private function GetTax($amount)
    {
        $sale = Tax::where('tax_name', 'sales')->value('tax_percentage');
        $salesPercent = floatval($sale);
        $taxCharge = 0.01 * $salesPercent * $amount;
        return $taxCharge;
    }
}
