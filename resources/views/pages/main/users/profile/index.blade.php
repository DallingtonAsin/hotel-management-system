@extends('layouts.template')

@section('content')

  <div class="card card-dashboard-table-six">
  <div class="card-body">

    <div class="jumbotron bg-glass">
      <div class="table table-responsive">
        
        <div class="wrapper">
          <div class="wrapper-div-1">
            <h6 class="text-success custom-green">Personal details</h6>
          </div>
  
          <div class="wrapper-div-2">
            <a href="{{route('account-settings')}}"><i class="fa fa-pen edit-pen"></i></a>
          </div>
        </div>

        <hr class="dotted-line">
        <table class="table  borderless">

          <tbody>
            <tr>
              <td class="text-muted">Name</td>
              <td class="text-right">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</td>
            </tr>

            <tr>
              <td class="text-muted">Staff Number</td>
              <td class="text-right">{{ Auth::user()->staff_id }}</td>
            </tr>

             <tr>
              <td class="text-muted">Username</td>
              <td class="text-right">{{ Auth::user()->username }}</td>
            </tr>

            <tr>
              <td class="text-muted">Gender</td>
              <td class="text-right">{{ Auth::user()->gender }}</td>
            </tr>

            <tr>
              <td class="text-muted">Email</td>
              <td class="text-right">{{ Auth::user()->email }}</td>
            </tr>

            <tr>
              <td class="text-muted">Phone Number</td>
              <td class="text-right">{{ Auth::user()->phone_number }}</td>
            </tr>

            <tr>
              <td class="text-muted">Department</td>
              <td class="text-right">{{ $department }}</td>
            </tr>

            <tr>
              <td class="text-muted">Designation</td>
              <td class="text-right">{{ $designation }}</td>
            </tr>


            <tr>
              <td class="text-muted">Address</td>
              <td class="text-right">{{ Auth::user()->address }}</td>
            </tr>

            @if(isset(Auth::user()->nin))
            <tr>
              <td class="text-muted">NIN</td>
              <td class="text-right">{{ Auth::user()->nin }}</td>
            </tr>
            @endif

            @if(isset(Auth::user()->tin_number))
            <tr>
              <td class="text-muted">Tin Number</td>
              <td class="text-right">{{ Auth::user()->tin_number }}</td>
            </tr>
            @endif

            @if(isset(Auth::user()->nssf_number))
            <tr>
              <td class="text-muted">NSSF Number</td>
              <td class="text-right">{{ Auth::user()->nssf_number }}</td>
            </tr>
            @endif

            @if(isset(Auth::user()->next_of_kin))
            <tr>
              <td class="text-muted">Next of Kin</td>
              <td class="text-right">{{ Auth::user()->next_of_kin }}</td>
            </tr>
            @endif

            <tr>
              <td class="text-muted">Staff Type</td>
              <td class="text-right">{{  Auth::user()->type }}</td>
            </tr>

            @if(isset(Auth::user()->status))
            <tr>
              <td class="text-muted">Status</td>
              <td class="text-right">{{ Auth::user()->status }}</td>
            </tr>
            @endif

            <tr>
              <td class="text-muted">Date of Account Creation</td>
              <td class="text-right"><span>{{ Auth::user()->created_at }}</span></td>
            </tr>

          </tbody>


        </table>
      </div>
    </div>

  </div>
</div>
@endsection
