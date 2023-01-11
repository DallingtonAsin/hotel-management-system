<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Kitchen\KitchenMenuItemCategoryDataTable;
use App\Models\KitchenMenuItemCategory;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;

class KitchenMenuItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_menu_item_cats = KitchenMenuItemCategory::count();
        return view('pages.main.kitchen.menu_item_cats')->with(compact('total_menu_item_cats'));
    }

    public function getKitchenMenuCategoriesOrdersDataTable(KitchenMenuItemCategoryDataTable $dataTable)
    {
        return $dataTable->render('pages.main.kitchen.menu_item_cats');
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
        ]);

        try {
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                return response()->json(['error' => $message]);
            } else {

                $name = ucfirst($request->input('name'));

                $exists = KitchenMenuItemCategory::where('name', $name)->exists();
                if ($exists) {
                    return response()->json(['error' => 'Menu item Category ' . $name . ' already exists']);
                } else {

                    $created_by = Helper::getLoggedInUserId();

                    $data = [
                        'name' => $name,
                        'created_by' => $created_by
                    ];

                    if (KitchenMenuItemCategory::create($data)) {
                        $message = "Kitchen menu item category " . $name . " has been added successfully";
                        $stats = $this->getMenuItemCatStats();
                        $data = [
                            'success' => $message,
                            'data' => $stats['data'],
                            'total' => $stats['total']
                        ];
                    } else {
                        $message = "Technical error in adding menu item category";
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

    public function fetchMenuItemCatAjax(Request $request)
    {
        try {
            if ($request->ajax()) {
                $departments = KitchenMenuItemCategory::get();
                echo json_encode($departments);
                die();

            }
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    private function getMenuItemCatStats()
    {
        try {

            $menuItemCats = KitchenMenuItemCategory::all();
            $total_categories = KitchenMenuItemCategory::count();

            $data = array(
                'data' => $menuItemCats,
                'total' => $total_categories
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
}
