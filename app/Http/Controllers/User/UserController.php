<?php

namespace App\Http\Controllers\User;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\UserRegistration;
use App\Jobs\MailRegistration;
use App\DataTables\ManagersDataTable;
use App\DataTables\CashiersDataTable;
use App\DataTables\UsersDataTable;
use App\DataTables\ActiveUserAccountsDataTable;
use App\DataTables\InactiveUserAccountsDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Staff;
use App\Helpers\Helper;
use Constant;


class UserController extends Controller
{

  public $controller;
  public function __construct()
  {
    $this->controller = 'UserController';
  }
  public function index(Request $request)
  {
    $response = Gate::inspect('isSuperAdmin');

    if ($response->allowed()) {

      try {
        $users = Staff::where('id', "!=", $request->user()->id)->get();
        $number_of_users = Staff::where('is_deleted', false)->count();
        return view('pages.users.index', ['total_staff' => $number_of_users])
          ->with(compact('users', 'number_of_users'));

      } catch (\Exception $ex) {
        $data = array(
          'username' => $request->username,
          'error_code' => $ex->getCode(),
          'error_message' => $ex->getMessage(),
          'error_severity' => Constant::$STATUS_ERROR_SEVERITY,
          'method' => 'index'
        );
        Helper::logError($data);
      }
    } else {
      // return view("errors.429");
    }
  }


  public function GetUsers(UsersDataTable $dataTable)
  {
    return $dataTable->render('pages.users.index');
  }

  public function GetManagers(ManagersDataTable $dataTable)
  {
    return $dataTable->render('pages.users.managers');
  }

  public function GetCashiers(CashiersDataTable $dataTable)
  {
    return $dataTable->render('pages.users.cashiers');
  }

  public function ActiveUsersAjax(ActiveUserAccountsDataTable $dataTable)
  {
    return $dataTable->render('pages.users.active-users');
  }


  public function ActiveUsersIndex(Request $request)
  {
    try {
      $response = Gate::inspect('isSuperAdmin');
      if ($response->allowed()) {
        $users = Staff::where('is_active', true)
          ->where('id', "!=", $request->user()->id)->get();
        $number_of_users = Staff::where('is_active', true)->count();
        return view('pages.users.active-users')
          ->with(compact('users', 'number_of_users'));

      }
    } catch (\Exception $ex) {
      dd($ex->getMessage());
    }
  }


  public function LockedUsersAjax(InactiveUserAccountsDataTable $dataTable)
  {
    return $dataTable->render('pages.users.inactive-users');
  }

  public function LockedUsersIndex(Request $request)
  {

    try {
      $response = Gate::inspect('isSuperAdmin');

      if ($response->allowed()) {
        $users = Staff::where('is_active', false)->get();
        $number_of_users = Staff::where('is_active', false)->count();
        return view('pages.users.inactive-users')
          ->with(compact('users', 'number_of_users'));
      }
    } catch (\Exception $ex) {
      dd($ex->getMessage());
    }
  }


  public function LockUnlockUserAccount(Request $request)
  {

    try {

      $user = $request->user();
      $admin = $user->first_name . '' . $user->last_name;
      $method = "LockUnlockUserAccount";
      if ($request->has('id') && $request->has('status')) {

        $id = $request->input('id');
        $status = $request->input('status');
        // dd($id, $status);

        $user = Staff::find($id);
        $name = $user->first_name . '' . $user->last_name;
        switch (true) {

          case ($status == true):
            $deactivated = Staff::where('id', $id)
              ->update(['is_active' => false, 'created_by' => $admin]);
            if ($deactivated) {

              $action = "deactivated user " . $name . "'s account";
              Helper::logger($request, $action, now());
              $dataArr = array(
                "code" => '200',
                "message" => $action,
                "method" => $method
              );
              Helper::LogRequest($request, $dataArr);
              return response()
                ->json(['success' => $this->ActionMessage($action)]);

            } else {

              $messageErr = 'Unable to deactivate user account!';
              $dataArr = array(
                "code" => '101',
                "message" => $messageErr,
                "method" => $method
              );
              Helper::LogRequest($request, $dataArr);
              return response()
                ->json(['error' => $messageErr]);
            }
            break;

          case ($status == false):
            $activated = Staff::where('id', $id)
              ->update([
                'is_active' => true,
                'loginAttempts' => 0,
                'otpAttempts' => 0,
                'created_by' => $admin
              ]);
            if ($activated) {

              $action = "activated user " . $name . "'s account";
              Helper::logger($request, $action, now());
              $dataArr = array(
                "code" => '200',
                "message" => $action,
                "method" => $method
              );
              Helper::LogRequest($request, $dataArr);
              return response()
                ->json(['success' => $this->ActionMessage($action)]);

            } else {
              $messageErr = 'Unable to change user account status!';
              $dataArr = array(
                "code" => '101',
                "message" => $messageErr,
                "method" => $method
              );
              Helper::LogRequest($request, $dataArr);
              return response()
                ->json(['error' => $messageErr]);
            }

            break;

        }

      } else {

        $messageErr = "Unable to get id and status in request";
        return response()
          ->json(['error' => $messageErr]);
      }

    } catch (\Exception $ex) {
      dd("Exception while locking/unlocking user account" . $ex->getMessage());
    }

  }


  public function LockUnlockAccount(Request $request, $id, $status, $name)
  {


    $response = Gate::inspect('isSuperAdmin');

    if ($response->allowed()) {
      $user = $request->user();
      $admin = $user->first_name . '' . $user->last_name;
      $method = "LockUnlockAccount";
      switch (true) {

        case ($status == true):
          $deactivated = Staff::where('id', $id)
            ->update(['is_active' => false, 'created_by' => $admin]);
          if ($deactivated) {

            $action = "deactivated user " . $name . "'s account";
            Helper::logger($request, $action, now());
            $dataArr = array(
              "code" => '200',
              "message" => $action,
              "method" => $method
            );
            Helper::LogRequest($request, $dataArr);
            return back()
              ->with('success', $this->ActionMessage($action));

          } else {

            $messageErr = 'Account deactivation failed!';
            $dataArr = array(
              "code" => '101',
              "message" => $messageErr,
              "method" => $method
            );
            Helper::LogRequest($request, $dataArr);
            return back()
              ->with('fail', $messageErr);
          }
          break;

        case ($status == false):
          $activated = Staff::where('id', $id)
            ->update([
              'is_active' => true,
              'loginAttempts' => 0,
              'otpAttempts' => 0,
              'created_by' => $admin
            ]);
          if ($activated) {

            $action = "activated user " . $name . "'s account";
            Helper::logger($request, $action, now());
            $dataArr = array(
              "code" => '200',
              "message" => $action,
              "method" => $method
            );
            Helper::LogRequest($request, $dataArr);
            return back()
              ->with('success', $this->ActionMessage($action));

          } else {
            $messageErr = 'Account activation failed!';
            $dataArr = array(
              "code" => '101',
              "message" => $messageErr,
              "method" => $method
            );
            Helper::LogRequest($request, $dataArr);
            return back()
              ->with('fail', $messageErr);
          }

          break;

      }
    }

  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.users.register');
  }


  protected function Enqueue($data)
  {
    MailRegistration::dispatch($data);
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
      'first_name' => 'required',
      'last_name' => 'required',
      'address' => 'required',
      'email' => 'sometimes|nullable|email',
      'phone_number' => 'required|min:10',
      'other_phone_number' => 'sometimes|nullable|min:10',
      'nin' => 'sometimes|nullable',
      'tin_number' => 'sometimes|nullable',
      'nssf_number' => 'sometimes|nullable',
      'next_of_kin' => 'sometimes|nullable',
      'department' => 'required',
      'designation' => 'required',
      'gender' => 'required',
      'staff_type' => 'required',
      'status' => 'required',
  ]);

  try {

      if ($validator->fails()) {
          $message = $validator->errors()->all();
          return response()->json(['error' => $message]);
      } else {

      $method = "UserController@store";

      $fname = $request->input('first_name');
      $lname = $request->input('last_name');
      $address = $request->input('address');
      $email = $request->input('email');
      $phone_number = $request->input('phone_number');
      $other_phone_number = $request->input('other_phone_number');
      $gender = $request->input('gender');
      $nin = $request->input('nin');
      $tin_number = $request->input('tin_number');
      $nssf_number = $request->input('nssf_number');
      $next_of_kin = $request->input('next_of_kin');
      $department_id = $request->input('department');
      $designation_id = $request->input('designation');
      $staff_type = ucfirst($request->input('staff_type'));
      $status = ucfirst($request->input('status'));

      $departmentObj = Department::find($department_id);
      $department_code = $departmentObj->code;
      $latest_id = Staff::latest()->first()->id;
      $staff_id = $department_code . str_pad($latest_id + 1, 4, '0', STR_PAD_LEFT);
     
      $designation = Designation::where('id', $designation_id)->value('name');

      $registra = $request->user()->name;
      $name = $fname . " " . $lname;
      $defaultPwd = '12345678';

      if ($request->has('id') && $request->filled('id')) {
        $user = Staff::find($request->input('id'));
        $username = $user->username;
        $password = $user->password;

      } else {
        $user = new Staff();
        $name = $fname . " " . $lname;
        $username = strtolower(Str::random(6) . "." . $fname);
        $password = Hash::make($defaultPwd, ['rounds' => 12]);
      }

      $bool_userExists = Staff::where('username', $username)->exists();

      if (!$request->filled('id') && $bool_userExists) {

        $message = "username " . $name . " has already been taken, choose another one";
        $dataArr = array(
          "code" => '101',
          "message" => $message,
          "method" => $method
        );

        Helper::LogRequest($request, $dataArr);
        return response()->json(['error' => $message]);

        } else {

          $user->first_name = $fname;
          $user->last_name = $lname;
          $user->username = $username;
          $user->gender = $gender;
          $user->email = $email;
          $user->staff_id = $staff_id;
          $user->department_id = $department_id;
          $user->designation_id = $designation_id;
          $user->phone_number = $phone_number;
          $user->other_phone_number = $other_phone_number;
          $user->address = $address;
          $user->nin = $nin;
          $user->tin_number = $tin_number;
          $user->nssf_number = $nssf_number;
          $user->next_of_kin = $next_of_kin;
          $user->type = $staff_type;
          $user->status = $status;
          $user->password = $password;
          $user->is_active = true;
          $user->created_by = $registra;

          $save_status = $user->save();
          if ($save_status) {

            $subject = 'User Registration';
            $userEmail = $request->email;
            $registraPosition = Designation::where('id', Auth::user()->designation_id)->value('name');
            $registraEmail = $request->user()->email;
            $default_password = $defaultPwd;
            $now = now();

            $action = "registered user " . $name . "";
            $sendAction = "You have been registered as a
                      " . $designation . " today at " . $now . "";
            Helper::logger($request, $action, now());

            $data = array(
              'name' => $name,
              'username' => $username,
              'password' => $default_password,
              'designation' => 'user',
              'registra' => $registra,
              'registraPosition' => $registraPosition,
              'registraEmail' => $registraEmail,
              'email' => $userEmail,
              'subject' => $subject,
              'created_at' => $now,
              'details' => $sendAction,
              'activity' => 'registration',
            );

            $message = "User " . $name . " has been registered successfully";
            $dataArr = array(
              "code" => '201',
              "message" => $message,
              "method" => $method
            );

            Helper::LogRequest($request, $dataArr);
            $statArr = Helper::GetUserStats();
            $number_of_users = $statArr['totl'];

            return response()->json(['success' => $message, 'total' => $number_of_users]);

          } else {
            $message = "User registration failed!";
            $dataArr = array(
              "code" => '101',
              "message" => $message,
              "method" => $method
            );
            Helper::LogRequest($request, $dataArr);
            return response()->json(['error', $message]);
          }
        }
      }
    } catch (\Exception $ex) {
      $statArr = Helper::GetUserStats();
      $number_of_users = $statArr['totl'];
      return response()->json(['error' => $ex->getMessage(), 'total' => $number_of_users]);
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
    $user = Staff::find($id);
    return response()->json($user);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $user = Staff::find($id);
    return response()->json($user);
  }

  protected function getUserRoleId($role)
  {
    $roleId = DB::table('departments')
      ->where('role', $role)
      ->value('id');
    return $roleId;

  }


  protected function searchRole(Request $request)
  {
    //  if($request->input('role')){
    $role = "user"; // $request->input('role');
    $roleId = $this->getUserRoleId($role);
    echo json_encode($roleId);
    // }

  }

  protected function validatorData(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'address' => 'required',
      'contact1' => 'required',
      // 'roleID' => 'required',
    ]);

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
    $this->validatorData($request);

    $user = Staff::find($id);
    $method = "UserController@update";

    $name = $request->input('name');
    $address = $request->input('address');
    $primary_phone_number = $request->input('contact1');
    $designationId = $request->input('designation');

    ($request->has('email') && $request->filled('email'))
      ? $email = $request->input('email')
      : $email = $user->email;

    ($request->has('contact2') && $request->filled('contact2'))
      ? $other_phone_number = $request->input('contact2')
      : $other_phone_number = $user->other_phone_number;

    $person = $user->name;
    $username = $user->username;

    $user->name = $name;
    $user->address = $address;
    $user->phone_number = $primary_phone_number;
    $user->other_phone_number = $other_phone_number;
    $user->email = $email;
    $user->department_id = $designationId;

    $registra = $request->user()->name;
    $userEmail = $request->email;
    $position = Helper::getDesignation($designationId);
    $registraPosition = Helper::getDesignation($request->user()->designation_id);
    $registraEmail = $request->user()->email;
    $default_password = "didn't change your password";
    $now = now();

    $isUpdated = $user->save();
    if ($isUpdated) {

      $subject = "Change of account details";
      $sendAction = "Your details have been edited by " . $registra . " today
            at " . $now . ". Check your profile to see what has been changed or not";

      $data = array(
        'name' => $name,
        'username' => $username,
        'password' => $default_password,
        'designation' => $position,
        'registra' => $registra,
        'registraPosition' => $registraPosition,
        'registraEmail' => $registraEmail,
        'email' => $userEmail,
        'subject' => $subject,
        'created_at' => $now,
        'details' => $sendAction,
        'activity' => 'detailsChange',
      );

      $user->notify(new UserRegistration($data));

      $this->Enqueue($data);

      $action = "updated details of user " . $person . " ins the system";
      Helper::logger($request, $action, now());
      $data = array(
        "code" => '200',
        "message" => $action,
        "method" => $method
      );
      Helper::LogRequest($request, $data);
      return back()
        ->with("success", $this->ActionMessage($action));

    } else {
      $messageErr = "Failedto update details of user " . $person . "!";
      $dataArr = array(
        "code" => '101',
        "message" => $messageErr,
        "method" => $method
      );
      Helper::LogRequest($request, $dataArr);
      return back()
        ->with('fail', $messageErr);
    }




  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * return \Illuminate\Http\Response
   */
  public function destroy(Request $request, $id)
  {

    // dd($id);
    $hasRights = Gate::inspect('isSuperAdmin');
    $hasRights1 = Gate::inspect('isAdmin');
    $user = Staff::find($id);
    $position = Helper::getDesignation($user->designation_id);
    if ($hasRights->allowed() || $hasRights1->allowed()) {

      $method = "UserController@destroy";
      $isDeleted = Staff::where('id', $id)->update(['is_deleted' => true]);

      if ($isDeleted) {
        $name = $user->name;
        $action = "removed user " . $name . " from the system";
        Helper::logger($request, $action, now());
        $data = array(
          "code" => '200',
          "message" => $action,
          "method" => $method
        );
        Helper::LogRequest($request, $data);
        $sessionVariable = 'success';
        $message = $this->ActionMessage($action);
      } else {

        $messageErr = "Users not removed from the system!";
        $dataArr = array(
          "code" => '101',
          "message" => $messageErr,
          "method" => $method
        );
        Helper::LogRequest($request, $dataArr);
        $sessionVariable = 'fail';
        $message = $messageErr;
      }

      $statArr = Helper::GetUserStats();
      $number_of_users = $statArr['totl'];

      return response()
        ->json([
          $sessionVariable => $message,
          'total' => $number_of_users,
        ]);

    }

  }

  public function RemoveAllActiveUsers(Request $request)
  {

    $response = Gate::inspect('isSuperAdmin');
    if ($response->allowed()) {

      $method = "UserController@RemoveAllActiveUsers";
      $isTruncated = Staff::where('is_active', true)->delete();
      if ($isTruncated) {

        $action = "removed all active users from the system";
        Helper::logger($request, $action, now());
        $data = array(
          "code" => '200',
          "message" => $action,
          "method" => $method
        );
        Helper::LogRequest($request, $data);
        return back()
          ->with("success", $this->ActionMessage($action));

      } else {
        $messageErr = 'Active users not removed from the system!';
        $dataArr = array(
          "code" => '101',
          "message" => $messageErr,
          "method" => $method
        );
        Helper::LogRequest($request, $dataArr);
        return back()
          ->with('fail', $messageErr);
      }

    }

  }

  public function RemoveAllLockedUsers(Request $request)
  {

    $response = Gate::inspect('isSuperAdmin');

    if ($response->allowed()) {
      $method = "UserController@RemoveAllLockedUsers";
      $isTruncated = Staff::where('is_active', false)->delete();
      if ($isTruncated) {

        $action = "removed all locked users from the system";
        Helper::logger($request, $action, now());
        $data = array(
          "code" => '200',
          "message" => $action,
          "method" => $method
        );
        Helper::LogRequest($request, $data);
        return back()
          ->with("success", $this->ActionMessage($action));

      } else {
        $messageErr = 'Locked users not removed from the system!';
        $dataArr = array(
          "code" => '101',
          "message" => $messageErr,
          "method" => $method
        );
        Helper::LogRequest($request, $dataArr);
        return back()
          ->with('fail', $messageErr);
      }

    }

  }


  public function RemoveSelected(Request $request)
  {
    try {
      $ids = $request->input('selected_rows');
      $DeletedUsers = array();

      if (count($ids) > 0) {
        $extUser = Staff::find($ids[0]);
        $position = Helper::getDesignation($extUser->designation_id);
        foreach ($ids as $id) {
          $user = Staff::find($id);
          $user->delete();
          array_push($DeletedUsers, $user->name);
        }
      }
      $sessionVariable = 'success';
      $deletedUsersStr = implode(", ", $DeletedUsers);
      $action = "removed users " . $deletedUsersStr . " from the system";
      if (count($ids) == 1) {
        $action = Str::replaceFirst('users', 'user', $action);
      }
      $response = $this->SuccessMessage($action);

      $dataArr = array(
        "code" => '200',
        "message" => $action,
        "method" => "UsersController@RemoveSelected"
      );
      Helper::logger($request, $action, now());
      Helper::LogRequest($request, $dataArr);

      $statArr = Helper::GetUserStats();
      $number_of_users = $statArr['totl'];

      return response()
        ->json([
          $sessionVariable => $response,
          'totl_no' => $number_of_users,
        ]);


    } catch (\Exception $ex) {
      $data = array(
        'username' => auth()->user()->username,
        'error_code' => $ex->getCode(),
        'error_message' => $ex->getMessage(),
        'error_severity' => Constant::$STATUS_ERROR_SEVERITY,
        'controller' => $this->controller,
        'method' => 'RemoveSelected'
      );
      Helper::logError($data);
      abort(409, $ex->getMessage());
    }
  }



  protected function ActionMessage($action)
  {
    $message = "You have successfully " . $action . "";
    return $message;
  }

  private function getUserRole($userRoleId)
  {
    $userRole = DB::table('departments')
      ->where('id', $userRoleId)
      ->value('role');
    return $userRole;

  }


  //method to check if there is internet connection

  public function is_connectedToInternet()
  {
    $connected = @fsockopen('www.google.com', 80);
    if ($connected) {
      $is_conn = 1;
      fclose($connected);
    } else {
      $is_conn = 0;
    }
    return $is_conn;
  }



  protected function SuccessMessage($msg)
  {
    $message = "You have successfully " . $msg . "";
    return $message;
  }


  protected function FailedMessage($failmsg)
  {
    $message = "" . $failmsg . "";
    return $message;
  }

  public function fetchStaffAjax(Request $request)
  {
      try {
          if ($request->ajax()) {
              $staff_members = Staff::get();
              echo json_encode($staff_members);
              die();
          }
      } catch (\Exception $ex) {
          echo "Error " . $ex->getMessage();
      }
  }

}