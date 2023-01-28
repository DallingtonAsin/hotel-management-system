<?php

namespace App\Http\Controllers\Finances;

use App\DataTables\Finances\PaymentCategoriesDataTable;
use App\Repositories\PaymentCategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentCategoryController extends Controller
{

    protected $paymentCategoryRepository;

    public function __construct(PaymentCategoryRepository $paymentCategoryRepository)
    {
         $this->paymentCategoryRepository = $paymentCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_categories = $this->paymentCategoryRepository->count();
        return view('pages.main.hr.finances.payment_categories')->with(compact('total_categories'));
    }


    public function getPaymentCategoriesDataTable(PaymentCategoriesDataTable $datatable){
        return $datatable->render('pages.main.hr.finances.payment_categories');
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
}
