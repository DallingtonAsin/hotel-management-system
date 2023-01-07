<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\DataTables\CompanyDataTable;
use App\Http\Controllers\LogsController;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{


    public function GetCompanies(CompanyDataTable $dataTable)
    {
        return $dataTable->render('pages.main.company.registration');
    }

    public function index()
    {
        $company_details = Company::first();
        if(!empty($company_details)){
            foreach($company_details as $k){
                $k->services = unserialize($k->services);
            }
        }
       
        $number_of_companies = Company::count();
        return view('pages.main.company.registration')->with(compact('company_details', 'number_of_companies'));

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



    public function showCreateCoForm()
    {
        $categories = ['1-star', '2-star', '3-star', '4-star', '5-star'];
        $services = ['swimming pool', 'fitness center', 'restaurant', 'business center'];
        $count = Company::count();
        $company = null;

        if($count > 0){
            $company = Company::first();
            $companyArray = $company->toArray();
            $company['services'] = unserialize($companyArray['services']);
           
        }

        return view('pages.main.company.registration')->with(compact('company', 'categories', 'services'));
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




    public function addUpdateCompany(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'street' => 'sometimes|nullable',
            'city' => 'required',
            'state' => 'sometimes|nullable',
            'zip' => 'sometimes|nullable',
            'phone_number' => 'required',
            'email' => 'sometimes|nullable',
            'website_url' => 'sometimes|nullable',
            'category' => 'required',
            'services' => 'required',
            'logo' => 'sometimes|nullable'
        ]);

        // dd($request);

        try {

            if ($validator->fails()) {
      
                return back()
                ->withErrors($validator)
                ->withInput();

            } else {

                $name = $request->input('name');
                $street = $request->input('street');
                $city = $request->input('city');
                $state = $request->input('state');
                $zip = $request->input('zip');

                $phone_number = $request->input('phone_number');
                $email = $request->input('email');
                $website_url = $request->input('website_url');
                $category = $request->input('category');
                $services = $request->input('services');

                if (!empty($services)) {
                    $services = serialize($services);
                }

                $details = [
                    'name' => $name,
                    'street' => $street,
                    'city' => $city,
                    'state' => $state,
                    'zip' => $zip,
                    'phone_number' => $phone_number,
                    'email' => $email,
                    'website_url' => $website_url,
                    'category' => $category,
                    'services' => $services,
                ];

                if ($request->hasfile('logo')) {
                    $this->validate($request, [
                        'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    ]);
                    $file = $request->file('logo');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move("uploads/images/company/logo", $filename);
                    $details['logo'] = $filename;
                }

                if (!empty($id)) {
                    $result = Company::where('id', $id)->update($details);
                    $action = 'updated';
                } else {
                    $result = Company::create($details);
                    $action = 'registered';
                }

                $message = "" . $action . " company " . $name . " profile";
                LogsController::logger($request, $message, now());

                if ($result) {
                    return back()->with('success', $this->ActionMessage($message));
                } else {
                    return back()->with('fail', 'Technical error in recording company details');
                }

            }

        } catch (\Exception $ex) {
            return back()->with('fail', $ex->getMessage());
        }

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

    protected function ActionMessage($action)
    {
        $message = "You have successfully " . $action . "";
        return $message;
    }




}