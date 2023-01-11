<?php

namespace App\Http\Controllers\kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        //
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
        //
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
