<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\pos\KitchenOrdersDataTable;
use App\Models\KitchenOrder;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class KitchenOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $total_orders = KitchenOrder::count();
        return view('pages.main.pos.kots')->with(compact('total_orders'));
    }

    public function getKitchenOrdersDataTable(KitchenOrdersDataTable $dataTable)
    {
        return $dataTable->render('pages.main.pos.kots');
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
            'table_number' => 'required|max:55',
            'item' => 'required|max:55',
            'quantity' => 'required|max:55',
            'status' => 'required|max:55',
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $table_number = $request->input('table_number');
                $item = $request->input('item');
                $quantity = $request->input('quantity');
                $status = $request->input('status');

                $order_number = $this->generateKotOrderNo();
                $created_by = Helper::getLoggedInUserId();

                $kot = [
                    'order_number' => $order_number,
                    'table_number' => $table_number,
                    'item' => $item,
                    'quantity' => $quantity,
                    'status' => $status,
                    'created_by' => $created_by,
                ];

                if (KitchenOrder::create($kot)) {
                    $message = "Kitchen order has been created successfully with order number" . $order_number . " ";
                    $stats = $this->GetKitchenOrderStats();
                    $data = [
                        'success' => $message,
                        'data' => $stats['data'],
                        'total' => $stats['total']
                    ];
                } else {
                    $message = "Technical error in adding kitchen order";
                    $data = [
                        'error' => $message
                    ];
                }
                return response()->json($data);
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    private function generateKotOrderNo()
    {
        try {
            $prefix = "#";
            $order_number = IdGenerator::generate(['table' => 'kitchen_orders', 'field' => 'order_number',  'length' => 10, 'prefix' => $prefix]);
            return $order_number;
        } catch (\Exception $ex) {
            throw $ex;
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
}