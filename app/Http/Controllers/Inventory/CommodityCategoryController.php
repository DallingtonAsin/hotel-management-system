<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Inventory\CommodityCategoriesDataTable;
use App\Repositories\CommodityCategoryRepository;

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
