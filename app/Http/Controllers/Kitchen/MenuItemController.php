<?php

namespace App\Http\Controllers\kitchen;

use App\DataTables\Kitchen\MenuItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\KitchenMenuItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\KitchenMenuItem;
use App\Helpers\Helper;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_menu_items = KitchenMenuItem::count();
        return view('pages.main.kitchen.menu_items')->with(compact('total_menu_items'));
    }

    public function getMenuItemsDataTable(MenuItemDataTable $dataTable)
    {
        return $dataTable->render('pages.main.kitchen.menu_items');
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
     * return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'description' => 'sometimes|nullable'
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $name = ucfirst($request->input('name'));
                $category_id = $request->input('category');

                $category = KitchenMenuItemCategory::where('id', $category_id)->value('name');

                $exists = KitchenMenuItem::where('name', $name)->where('category_id', $category_id)->exists();
                if ($exists) {
                    return response()->json(['error' => 'Menu item ' . $name . ' already exists in category '.$category.'']);
                } else {

                    $description = $request->input('description');
                    $price = Helper::Numberize($request->input('price'));
                    $created_by = Helper::getLoggedInUserId();

                    $data = [
                        'name' => $name,
                        'description' => $description,
                        'price' => $price,
                        'category_id' => $category_id,
                        'created_by' => $created_by
                    ];

                    if (KitchenMenuItem::create($data)) {
                        $message = "Menu item " . $name . " has been added successfully";
                        $stats = $this->getMenuItemStats();
                        $data = [
                            'success' => $message,
                            'data' => $stats['data'],
                            'total' => $stats['total']
                        ];
                    } else {

                        $message = "Technical error in adding menu item";
                        $data = [
                            'error' => $message
                        ];
                    }
                    return response()->json($data);
                }
            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    private function getMenuItemStats()
    {
        try {

            $menu_items = KitchenMenuItem::all();
            $total_menu_items = KitchenMenuItem::count();

            $data = array(
                'data' => $menu_items,
                'total' => $total_menu_items
            );

            return $data;
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

    public function fetchMenuItemsAjax(Request $request)
    {
        try {
            if ($request->ajax()) {
                $menu_items = KitchenMenuItem::get();
                echo json_encode($menu_items);
                die();
            }
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function getMenuItemPrice(Request $request, $menu_item_id)
    {
        try {
            if ($request->ajax()) {
                $menu_item = Helper::getMenuItem($menu_item_id);
                $menu_item_price = number_format(round($menu_item->price));
                echo json_encode($menu_item_price);
                die();
            }
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function getMenuItem(Request $request, $menu_item_id){
        try {
            $menu_item_data = KitchenMenuItem::where('id', $menu_item_id)->get();
            return json_encode(array('data' => $menu_item_data));
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }







}
