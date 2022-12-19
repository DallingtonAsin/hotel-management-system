<?php


namespace App\Http\View\Composers;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Company;

class ComposerGlobals{

  public function compose(View $view){

    $company = Company::where('company_name', '!=', null)->first();
    $view->with('companyData', $company);

  }

}
