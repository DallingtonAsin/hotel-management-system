<?php


namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class ComposerOverview
{

  public function compose(View $view)
  {

    $company = Company::where('id', '!=', null)->first();
    if(empty($company)){
      $company = new Company();
      $company->name = config('app.HOTEL_NAME');
      $company->street = config('app.HOTEL_STREET');
      $company->city = config('app.HOTEL_CITY');
      $company->state = config('app.HOTEL_STATE');
      $company->zip = config('app.HOTEL_ZIP');
      $company->phone_number = config('app.HOTEL_PHONE_NUMBER');
      $company->email = config('app.HOTEL_EMAIL');
      $company->is_registered = false;
      $company->logo = "";
    }

    if(!empty($company->services)){
      $company->services = unserialize($company->services);
    }else{
      $company->services = [];
    }

      $view->with('company', $company);

  }
}
