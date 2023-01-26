<?php


namespace App\Http\View\Composers;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Staff;
use App\Models\Stock;
use App\Models\Sale;
use App\Models\Damage;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\TopCashier;
use App\Models\DebtorsCustomer;
use App\Models\DebtorsSupplier;
use App\Models\Department;

class ComposerOverview{

  public function compose(View $view){

    $items_in_stock = Stock::count();
    $total_sales = Sale::count();
    $total_damages = Damage::count();
    $total_suppliers = Supplier::count();
    $total_customers = Customer::count();
    $total_expenses = Expense::count();
    $top_cashiers = TopCashier::paginate(5);
    $debtorsCustomers = DebtorsCustomer::paginate(4);
    $total_customersDebts = DebtorsCustomer::sum('debts');
    $total_suppliersDebts = DebtorsSupplier::sum('debts');
    $totlSystemUsers = DB::table("staff")->count();
    $totlActiveUsers = DB::table("staff")->where('is_active', true)->count();
    $totlLockedUsers = DB::table("staff")->where('is_active', false)->count();
    $fiveSuperAdmin = Staff::limit(5)->get();




    $data = array(
      'num_of_stockItems' => $items_in_stock,
      'total_sales' => $total_sales,
      'total_damages' => $total_damages,
      'total_suppliers' => $total_suppliers,
      'total_customers' => $total_customers,
      'total_expenses' => $total_expenses,
      'top_cashiers' => $top_cashiers,
      'debtorsCustomers' => $debtorsCustomers,
      'totalCustomerDebts' => $total_customersDebts,
      'totalSupplierDebts' => $total_suppliersDebts,
      'totlSystemUsers' => $totlSystemUsers,
      'totlActiveUsers' => $totlActiveUsers,
      'totlLockedUsers' => $totlLockedUsers,
      'totlSuperAdmin' => $this->getNumberofSuperAdmin(),
      'superAdminArr' => $fiveSuperAdmin,
    );

     $response = Gate::inspect('isSuperAdmin');
        if($response->allowed())
        { 
            $view->with('registeredDepartments', $this->getDepartments());

        }


    if(Auth::check())
    {
     $id = Auth::user()->id;
     $view->with('department_id', $this->getUserDepartment());
     $view->with('data', $data);
   }
   else
   {
    return redirect('/home');
  }



}



   public function getDepartments()
   {
    $departments = DB::table('departments')
                     ->get();
    return $departments;
   }


    public function getUserDepartment()
    {
      $userDepartment = DB::table('departments')
                 ->where('id', Auth::user()->department_id)
                  ->value('name');
      return $userDepartment;

    }

    public function getDepartmentId($name)
    {
      $id = Department::where("name", $name)->value("id");
      return $id;
    }

    public function getNumberofSuperAdmin()
    {
       $department = "SuperAdministrator";
       $userDepartmentId = $this->getDepartmentId($department);
       $totl = Staff::where("department_id", $userDepartmentId)->count();
       return $totl;
    }

    


}
