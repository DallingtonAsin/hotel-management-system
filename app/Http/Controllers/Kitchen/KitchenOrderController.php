<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DataTables\Kitchen\KitchenOrdersDataTable;
use App\DataTables\Kitchen\OrderHistoryDataTable;
use App\Helpers\Helper;
use App\Models\Guest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\KitchenOrder;
use App\Models\KitchenOrderItem;
use App\Models\KitchenOrderInvoice;
use App\Models\KitchenMenuItem;
use DataTable;


class KitchenOrderController extends Controller
{

    private $sold_menu_items = array();
    private $total_amount_of_sales = 0;
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $total_orders = KitchenOrder::where('status', config('kitchen-order-statuses')['pending'])->count();
        return view('pages.main.kitchen.orders.new')->with(compact('total_orders'));
    }

    public function getKitchenOrdersDataTable(KitchenOrdersDataTable $dataTable)
    {
        return $dataTable->render('pages.main.kitchen.orders.new');
    }

    public function orderHistoryIndex()
    {
        $total_orders = KitchenOrder::count();
        return view('pages.main.kitchen.orders.history')->with(compact('total_orders'));
    }

    public function getOrderHistoryDataTable(OrderHistoryDataTable $dataTable)
    {
        return $dataTable->render('pages.main.kitchen.orders.history');
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
     *  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'table_data' => 'required',
            'table_number' => 'sometimes|nullable',
            'room_number' => 'sometimes|nullable',
            'guest_id' => 'sometimes|nullable',
            'customer_name' => 'sometimes|nullable',
            'phone_number' => 'sometimes|nullable',
            'tin_number' => 'sometimes|nullable',
            'email' => 'sometimes|nullable',
            'status' => 'required',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $method = "KitchenOrderController@storeKitchenOrder";
                $data = $request->input('table_data');

                $order_number = Helper::generateUniqueNumber('kitchen_orders', 'order_number', 10, 'KOT_');
                $table_number = $request->input('table_number');

                $status = strtolower($request->input('status'));
                $order_date = Carbon::now();
                $created_by = Helper::getLoggedInUserId();


                if ($request->filled('room_number')) {
                    $room_number = $request->input('room_number');
                    $room = Room::where('number', $room_number);
                    if (!$room->exists()) {
                        return response()->json(['error' => 'Unable to find sepcified room number']);
                    } else {
                        $room_id = $room->value('id');
                    }
                } else {
                    $room_id = null;
                }

                $guest_id = $request->input('guest_id');
                $customer_name = $request->input('customer_name');
                $phone_number = $request->input('phone_number');
                $tin_number = $request->input('tin_number');
                $email = $request->input('email');

                $kitchenOrderData = [
                    'order_number' => $order_number,
                    'table_number' => $table_number,
                    'room_id' => $room_id,
                    'guest_id' => $guest_id,
                    'customer_name' => $customer_name,
                    'phone_number' => $phone_number,
                    'tin_number' => $tin_number,
                    'email' => $email,
                    'status' => $status,
                    'order_date' => $order_date,
                    'created_by' => $created_by,
                ];

                $isKOCreated = KitchenOrder::create($kitchenOrderData);
                if ($isKOCreated) {

                    // store kitchen order items
                    $dataArr = json_decode($data, true);
                    if (is_array($dataArr) && count($dataArr) > 0) {

                        foreach ($dataArr as $key) {

                            $item = $key['item'];
                            $this->sold_menu_items[] = $item;

                            $menu_item = KitchenMenuItem::where('name', 'like', "%" . $item . "%")->first();
                            $menu_item_id = $menu_item->id;
                            $price = $menu_item->price;
                            $quantity = Helper::Numberize($key['quantity']);

                            if (!empty($price)) {
                                $price = Helper::Numberize($key['price']);
                            }

                            $sub_total = $quantity * $price;
                            $this->total_amount_of_sales += floatval($sub_total);

                            KitchenOrderItem::create([
                                'order_number' => $order_number,
                                'item_id' => $menu_item_id,
                                'quantity' => $quantity,
                                'price' => $price,
                                'total' => $sub_total,
                            ]);
                        }

                        $sub_total = $this->total_amount_of_sales;
                        $tax_amount = 0.18 * $sub_total;
                        $total_amount = $tax_amount + $sub_total;

                        $kitchenOrderInvoice = [
                            'order_number' => $order_number,
                            'sub_total' => $sub_total,
                            'tax' => $tax_amount,
                            'total' => $total_amount,
                            'status' => $status
                        ];

                        $hasInsertedInKOITbl = KitchenOrderInvoice::create($kitchenOrderInvoice);

                        //If insertion is OK, reduce stock levels and clear cart
                        if ($hasInsertedInKOITbl) {
                            $message = "Kitchen order has been recorded successfully with order number " . $order_number . "";
                            $responseData = [
                                'success' => $message
                            ];
                            $action = "recorded a sale of items " . json_encode($this->sold_menu_items) . " at
                        " . number_format($total_amount) . " with tax inclusive";

                            Helper::logger($request, $action, now());
                            $dataArr = array("code" => '200', "message" => $action, "method" => $method);
                            Helper::LogRequest($request, $dataArr);
                        } else {

                            $message = "Failed to create invoice for the kitchen order";
                            $responseData = [
                                'error' => $message
                            ];
                            $dataArr = array(
                                "code" => '101',
                                "message" => $message,
                                "method" => $method
                            );
                            Helper::LogRequest($request, $dataArr);
                        }
                    } else {
                        $message = "Invalid kitchen order data";
                        $responseData = [
                            'error' => $message
                        ];
                    }

                    return response()->json($responseData);
                } else {
                    return response()->json(['error' => 'Unable to record order in kitchen orders']);
                }
            }
        } catch (\Exception $ex) {
            return response()->json(['error' =>  $ex->getMessage()]);
        }
    }


    public function changeKitchenOrderStatus(Request $request, $id)
    {

        if (!empty($id)) {

            $order_statuses = config('kitchen-order-statuses');
            $validator = Validator::make($request->all(), [
                'status' => 'required',
            ]);

            $order_status = $request->input('status');
            if ($order_status == $order_statuses['completed']) {
                $validator = Validator::make($request->all(), [
                    'payment_method' => 'required',
                    'payment_date' => 'required',
                ]);
            }

            if ($order_status == $order_statuses['cancelled']) {
                $validator = Validator::make($request->all(), [
                    'reason' => 'required',
                ]);
            }

            try {
                if ($validator->fails()) {
                    $message = $validator->errors()->all();
                    return response()->json(['error' => $message]);
                } else {

                    $order_status = strtolower($order_status);
                    $kitchen_order = KitchenOrder::find($id);
                    $order_number = $kitchen_order->order_number;

                    if ($kitchen_order->update(['status' => $order_status])) {

                        $ko_invoice = array();
                        $ko_invoice['status'] = $order_status;
                        if ($order_status == $order_statuses['completed']) {
                            $ko_invoice['payment_method'] = $request->input('payment_method');
                            $ko_invoice['paid_at'] = $request->input('payment_date');
                            $ko_invoice['completed_by'] = Auth::user()->id;
                        } else if ($order_status == $order_statuses['cancelled']) {
                            $ko_invoice['cancelled_for'] = $request->input('reason');
                            $ko_invoice['cancelled_at'] = Carbon::now();
                            $ko_invoice['cancelled_by'] = Auth::user()->id;
                        }

                        $ko_updated = KitchenOrderInvoice::where('order_number', $order_number)->update($ko_invoice);
                        if ($ko_updated) {
                            $message = "Kitchen order " . $order_number . " has been marked " . lcfirst($order_status) . " successfully";
                            $stats = $this->GetKitchenOrderStats();
                            $data = [
                                'success' => $message,
                                'data' => $stats['data'],
                                'total' => $stats['total']
                            ];
                        } else {
                            $message = "Technical error in updating invoice status";
                            $data = [
                                'error' => $message
                            ];
                        }
                    } else {
                        $message = "Technical error in updating kitchen order status";
                        $data = [
                            'error' => $message
                        ];
                    }
                    return response()->json($data);
                }
            } catch (\Exception $ex) {
                return response()->json(['error' => $ex->getMessage()]);
            }
        } else {
            return response()->json(['error' => 'System is unable to capture order id']);
        }
    }

    private function getOrderDetails($id)
    {
        try {

            $kitchen_order = KitchenOrder::find($id);
            $order_items = KitchenOrderItem::where('order_number', $kitchen_order->order_number)->get();

            foreach ($order_items as $item) {
                $item->name = KitchenMenuItem::where('id', $item->item_id)->value('name');
            }

            $kitchen_order->items = $order_items;

            $order_invoice = KitchenOrderInvoice::where('order_number', $kitchen_order->order_number)->get();
            foreach ($order_invoice as $invoice) {
                if ($invoice->completed_by) {
                    $invoice->completed_by = Helper::getUserNames($invoice->completed_by);
                }
                if ($invoice->cancelled_by) {
                    $invoice->cancelled_by = Helper::getUserNames($invoice->cancelled_by);
                }
                if ($invoice->paid_at) {
                    $invoice->paid_at = date('d-M-Y H:i A', strtotime($invoice->paid_at));
                }
                if ($invoice->cancelled_at) {
                    $invoice->cancelled_at = date('d-M-Y H:i A', strtotime($invoice->cancelled_at));
                }
                if ($invoice->payment_method) {
                    $invoice->payment_method = ucwords($invoice->payment_method);
                }
            }
            $kitchen_order->invoice = $order_invoice;

            if ($kitchen_order->guest_id) {
                $guest = Guest::find($kitchen_order->guest_id);
                $kitchen_order->guest = $guest;
            }

            if ($kitchen_order->room_id) {
                $room = Room::find($kitchen_order->room_id);
                $kitchen_order->room_number = $room->number;
            }

            return response()->json(['success' => 'Ok', 'data' => $kitchen_order]);
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
        return $this->getOrderDetails($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->getOrderDetails($id);
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

    private function GetKitchenOrderStats()
    {
        try {

            $kitchen_orders = KitchenOrder::all();
            $total_kitchen_orders = KitchenOrder::count();

            $data = array(
                'data' => $kitchen_orders,
                'total' => $total_kitchen_orders
            );

            return $data;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }


    public function orderStatusIndex(Request $request, $status)
    {
        $total_orders = KitchenOrder::where('status', $status)->count();
        return view('pages.main.kitchen.orders.status')->with(compact('total_orders', 'status'));
    }


    public function getOrders(Request $request, $status)
    {

        try {
            if ($status) {

                $orders = KitchenOrder::select(['id', 'order_number', 'table_number', 'room_id', 'guest_id', 'customer_name', 'tin_number', 'phone_number', 'email', 'status', 'order_date', 'created_by']);

                // filter orders based on status
                $orders->where('status', $status);

                return DataTable::of($orders)
                    ->addIndexColumn()
                    ->addColumn('action', function ($order) {

                        $btn = "";

                        $btn .= '<a href="javascript:void(0);" id="view-kitchen-order" 
                    data-toggle="tooltip" data-original-title="view order"
                    data-id="' . $order->id . '" data-status="{{$status}}"
                     class="px-3 py-1 border border-primary rounded mr-2 text-primary">view order</a>';

                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" 
                     data-id="' . $order->id . '" data-original-title="Download Invoice" id="download-general-invoice"
                     class="px-3 py-1 border border-secondary rounded text-secondary ml-2">
                     invoice</a>';

                        return $btn;
                    })->addColumn('room_number', function ($order) {
                        $room_number = null;
                        if (isset($order->room_id)) {
                            $room = Helper::findRoom(($order->room_id));
                            $room_number = $room->number;
                        }
                        return $room_number;
                    })->editColumn('order_date', function ($order) {
                        return date('Y-m-d H:i A', strtotime($order->order_date));
                    })->editColumn('created_by', function ($order) {
                        if (!empty($order->created_by)) {
                            return Helper::getUserNames($order->created_by);
                        } else {
                            return "Unknown";
                        }
                    })->rawColumns(['action'])
                    ->make(true);

                return view('pages.main.kitchen.orders.status');
            } else {
                return response()->json(['error' => 'No order status found']);
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
}
