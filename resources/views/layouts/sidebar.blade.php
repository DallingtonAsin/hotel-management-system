<div class="az-sidebar bg-primary-dark">
  <div class="az-sidebar-loggedin nunito-font">
    <div class="az-img-user user-img">

      @isset(Auth::user()->image)
      <img src="{{ asset('uploads/images/'.$department_id.'/'.Auth::user()->image.'') }}" alt="">
      @endisset

      @empty(Auth::user()->image)
      <img src="{{ asset('uploads/images/default/user.png') }}" alt="{{Auth::user()->first_name}}">
      @endempty

    </div>
    <div class="media-body pt-2 pl-1">

      @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
      @endif

      <h6 class="user-profile-name text-cap">
        @isset(Auth::user()->name)
        {{ Auth::user()->first_name }}
        @endisset
        @empty(Auth::user()->name || Auth::user()->email)
        {{ __('Guest') }}
        @endempty
      </h6>

      <span class="online text-white nunito-font pt-2">
        <i class="fa fa-circle text-success"></i>
        {{__('online') }}
      </span>
    </div>
  </div>

  @php
  ($department_id == "Administrator" || $department_id == "SuperAdministrator")
  ? $show = ""
  : $show = "";
  @endphp

  @php
  ($department_id == "SuperAdministrator")
  ? $active = ""
  : $active = "";
  @endphp

  <div class="az-sidebar-body nunito-font">
    <ul class="nav">
      <li class="nav-label">Main Menu</li>


      <li><a href="{{ route('home') }}" class="nav-link"><i class="fa fa-home"></i>Home</a></li>
  

      <li class="nav-item {{ $show }} ">
        <a href="" class="nav-link with-sub"><i class="typcn typcn-clipboard"></i>Dashboard</a>

        <ul class="nav-sub">
          <li class="nav-sub-item"><a href="{{ Route('expenses.index') }}" class="nav-sub-link">
              Expenses
            </a></li>
          <li class="nav-sub-item"><a href="{{ Route('customers.with.debts') }}" class="nav-sub-link"> Customers with debts</a></li>
          <li class="nav-sub-item"><a href="{{ Route('customers.debts.payments.index') }}" class="nav-sub-link">Customer debt payments</a></li>

        </ul>
    
      </li>

      <li class="nav-item">
        <a href="" class="nav-link with-sub"><i class="fa fa-shopping-cart"></i>Restaurant & Bar</a>
        <ul class="nav-sub">
          <li class="nav-sub-item"><a href="{{ Route('sales.debts') }}" class="nav-sub-link">Sales with debts</a></li>
          <li class="nav-sub-item"><a href="{{ route('m-sales') }}" class="nav-sub-link">Monthly statistics</a></li>

        </ul>
      </li>

      <!-- <li class="nav-item">
        <a href="" class="nav-link with-sub"><i class="typcn typcn-location"></i>Events</a>
        <ul class="nav-sub">
          <li class="nav-sub-item"><a href="{{ Route('events.index') }}" class="nav-sub-link">Events</a></li>
          <li class="nav-sub-item"><a href="{{ Route('calendar.index') }}" class="nav-sub-link">Calendar</a></li>
          <li class="nav-sub-item"><a href="{{ Route('events.create') }}" class="nav-sub-link">Add Event</a></li>
        </ul>
      </li> -->

      <li class="nav-item">
        <a href="" class="nav-link with-sub"><i class="fa fa-balance-scale"></i>Accounting</a>

        <ul class="nav-sub">
          <li class="nav-sub-item"><a href="{{ Route('sales.index') }}" class="nav-sub-link">Sales</a></li>
          <li class="nav-sub-item"><a href="{{ route('companies.create') }}" class="nav-sub-link">Cash In flow</a></li>
          <li class="nav-sub-item"><a href="{{ route('companies.create') }}" class="nav-sub-link">General Ledger</a></li>

        </ul>
      </li>
     

      <li class="nav-item {{ $show }} ">
        <a href="" class="nav-link with-sub"><i class="typcn typcn-clipboard"></i>Store & Procurement</a>

        <ul class="nav-sub">
          <li class="nav-item">
            <a href="" class="nav-link with-sub">Stock</a>
            <ul class="nav-sub">

              <li class="nav-sub-item"><a href="{{ Route('stock.index') }}" class="nav-sub-link">Stock</a></li>
              <li class="nav-sub-item"><a href="{{ Route('purchases.index') }}" class="nav-sub-link">Purchases</a></li>
              <li class="nav-sub-item"><a href="{{ Route('damaged-stock-items.index') }}" class="nav-sub-link">Damaged Stock</a></li>
              <li class="nav-sub-item"><a href="{{ Route('product-categories.index') }}" class="nav-sub-link">Product Categories</a></li>
            </ul>
          </li>

          <li class="nav-sub-item"><a href="{{ Route('suppliers.index') }}" class="nav-sub-link">
              Vendors
            </a></li>
          <li class="nav-sub-item"><a href="{{ Route('expenses.index') }}" class="nav-sub-link">
              Expenses
            </a></li>
          <li class="nav-sub-item"><a href="{{ Route('customers.with.debts') }}" class="nav-sub-link"> Customers with debts</a></li>
          <li class="nav-sub-item"><a href="{{ Route('customers.debts.payments.index') }}" class="nav-sub-link">Customer debt payments</a></li>

        </ul>
    
      </li>

      <li class="nav-item {{ $show }} ">
        <a href="" class="nav-link with-sub"><i class="typcn typcn-clipboard"></i>House Keeping</a>

        <ul class="nav-sub">
          <li class="nav-item">
            <a href="" class="nav-link with-sub">Stock</a>
            <ul class="nav-sub">

              <li class="nav-sub-item"><a href="{{ Route('stock.index') }}" class="nav-sub-link">Stock</a></li>
              <li class="nav-sub-item"><a href="{{ Route('purchases.index') }}" class="nav-sub-link">Purchases</a></li>
              <li class="nav-sub-item"><a href="{{ Route('damaged-stock-items.index') }}" class="nav-sub-link">Damaged Stock</a></li>
              <li class="nav-sub-item"><a href="{{ Route('product-categories.index') }}" class="nav-sub-link">Product Categories</a></li>
            </ul>
          </li>

          <li class="nav-sub-item"><a href="{{ Route('suppliers.index') }}" class="nav-sub-link">
              Vendors
            </a></li>
          <li class="nav-sub-item"><a href="{{ Route('expenses.index') }}" class="nav-sub-link">
              Expenses
            </a></li>
          <li class="nav-sub-item"><a href="{{ Route('customers.with.debts') }}" class="nav-sub-link"> Customers with debts</a></li>
          <li class="nav-sub-item"><a href="{{ Route('customers.debts.payments.index') }}" class="nav-sub-link">Customer debt payments</a></li>

        </ul>
    
      </li>

      <li class="nav-item {{ $show }} ">
        <a href="" class="nav-link with-sub"><i class="fa fa-landmark"></i>Accomodation</a>

        <ul class="nav-sub">
          <li class="nav-item">
            <a href="" class="nav-link with-sub">Rooms</a>
            <ul class="nav-sub">
            <li class="nav-sub-item"><a href="{{ Route('rooms.index') }}" class="nav-sub-link">All rooms</a></li>
              <li class="nav-sub-item"><a href="{{ Route('room_types.index') }}" class="nav-sub-link">Room types</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="" class="nav-link with-sub">Guests</a>
            <ul class="nav-sub">
              <li class="nav-sub-item"><a href="{{ Route('stock.index') }}" class="nav-sub-link">Guest types</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="" class="nav-link with-sub">Bookings</a>
            <ul class="nav-sub">
            <li class="nav-sub-item"><a href="{{ Route('purchases.index') }}" class="nav-sub-link">All bookings</a></li>
              <li class="nav-sub-item"><a href="{{ Route('stock.index') }}" class="nav-sub-link">Add booking</a></li>
            </ul>
          </li>

    
        </ul>
    
      </li>
 
      <li class="nav-item">
        <a href="" class="nav-link with-sub"><i class="fa fa-users"></i>Human Resource</a>
        <ul class="nav-sub">
          <li class="nav-sub-item"><a href="{{ route('companies.create') }}" class="nav-sub-link">Departments</a></li>
          <li class="nav-sub-item"><a href="{{ route('companies.create') }}" class="nav-sub-link">Staff members</a></li>
          <li class="nav-sub-item"><a href="{{ route('companies.create') }}" class="nav-sub-link">Salary Payments</a></li>
          <li class="nav-sub-item"><a href="{{ route('companies.create') }}" class="nav-sub-link">Other Staff Payments</a></li>


        </ul>
      </li>

      <li class="nav-item">
        <a href="" class="nav-link with-sub"><i class="fa fa-chart-area"></i>Reports</a>
        <ul class="nav-sub">
          <li class="nav-sub-item"><a href="{{ route('top-cashiers')}}" class="nav-sub-link">Cashiers report</a></li>
          <li class="nav-item">
            <a href="" class="nav-link with-sub">Debtors</a>
            <ul class="nav-sub">
              <li class="nav-sub-item"><a href="{{ route('debtors-suppliers') }}" class="nav-sub-link">Suppliers</a></li>
              <li class="nav-sub-item"><a href="{{ route('debtors-customers') }}" class="nav-sub-link">Customers</a></li>
            </ul>
          </li>

          <li class="nav-sub-item"><a href="{{ route('top-customers')}}" class="nav-sub-link">Top Customers</a></li>

          <li class="nav-item">
            <a href="" class="nav-link with-sub">Stock</a>
            <ul class="nav-sub">
              <li class="nav-sub-item"><a href="{{ route('best-selling-items') }}" class="nav-sub-link">Best selling products</a></li>
              <li class="nav-sub-item"><a href="{{ route('low-stock',':quantity') }}" class="nav-sub-link">
                  Low running stock</a></li>
            </ul>
          </li>

          <li class="nav-sub-item"><a href="{{ url('/reports') }}" class="nav-sub-link">Sales</a></li>
          <li class="nav-sub-item"><a href="{{ url('/reports/charts/purchases') }}" class="nav-sub-link">Purchases</a></li>


        </ul>
      </li>
  
      <li class="nav-item">
        <a href="" class="nav-link with-sub"><i class="typcn typcn-cog"></i>Others</a>

        <ul class="nav-sub">
          <li class="nav-sub-item"><a href="{{ route('companies.create') }}" class="nav-sub-link">Settings</a></li>
        </ul>

        <ul class="nav-sub">
          <li class="nav-sub-item"><a href="{{ route('mail.index') }}" class="nav-sub-link">Send Email</a></li>
        </ul>

        <ul class="nav-sub">
          <li class="nav-sub-item"><a href="{{ route('logs.index') }}" class="nav-sub-link"> System audit</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>


<div class="az-content az-content-dashboard-five">

  <div class="az-header">
    <div class="container-fluid">

      <div class="az-header-left">
        <a href="" id="azSidebarToggle" class="az-header-menu-icon"><span></span></a>
      </div>

      <div class="az-header-center nunito-font">
        <h5 class="nav-label colored-icon-1">
          @if(isset($companyData))
          {{ $companyData['company_name'] }}
          @else
          {{ env('APP_NAME') }}
          @endif
        </h5>
      </div>

      <div class="dropdown az-profile-menu">
        <a href="" class="text-decoration-none nunito-font username text-cap">
          <span class="mt-5">{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}} </span>
          <i class="dropdown-toggle"></i></a>
        <div class="dropdown-menu">
          <div class="az-dropdown-header d-sm-none">
            <a href="" class="az-header-arrow">
              <i class="icon ion-md-arrow-back"></i>
            </a>
          </div>

          <div class="az-header-profile nunito-font">
            <div class="az-img-user ">
              @isset(Auth::user()->image)
              <img src="{{ asset('uploads/images/'.$department_id.'/'.Auth::user()->image.'') }}" alt="">
              @endisset

              @empty(Auth::user()->image)
              <img src="{{ asset('uploads/images/default/user.png') }}" alt="{{Auth::user()->name}}" class="az-img-user pull-right">
              @endempty
            </div>
            <div class="text-center">
              <label class="text-cap">{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}</label>
              <span>{{{ $department_id }}}</span>
            </div>
          </div>

          <a href="{{ Route('profile.index') }}" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
          <a href="{{route('account-settings')}}" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
          <a href="{{ route('logs.index' )}}" class="dropdown-item"><i class="typcn typcn-time"></i> Activity Logs</a>
          <a href="{{route('account-settings')}}" class="dropdown-item">
            <i class="typcn typcn-cog-outline"></i> Account Settings</a>
          <a class="dropdown-item" href="{{ route('signout') }}">
            <i class="typcn typcn-power-outline"></i>{{ __('Sign Out') }}
          </a>

        </div>
      </div>
    </div>
  </div>

  <div class="az-content-body nunito-font">
    @yield('content')
  </div>
  @include('layouts.footer')
</div>