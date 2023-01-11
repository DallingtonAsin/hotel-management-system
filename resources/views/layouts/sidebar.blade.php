<div class="az-sidebar bg-primary-dark">
    <div class="az-sidebar-loggedin nunito-font">
        <div class="az-img-user user-img">

            @isset(Auth::user()->image)
                <img src="{{ asset('uploads/images/' . $department_id . '/' . Auth::user()->image . '') }}" alt="">
            @endisset

            @empty(Auth::user()->image)
                <img src="{{ asset('uploads/images/default/user.png') }}" alt="{{ Auth::user()->first_name }}">
            @endempty

        </div>
        <div class="media-body pt-2 pl-1">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <h6 class="user-profile-name text-cap">
                @isset(Auth::user()->first_name)
                    {{ Auth::user()->first_name }}
                @endisset
            </h6>

            <span class="online text-white nunito-font pt-2">
                <i class="fa fa-circle text-success"></i>
                {{ __('online') }}
            </span>
        </div>
    </div>

    @php($department_id == 'Administrator' || $department_id == 'SuperAdministrator')
    ? $show = ""
    : $show = "";
    @endphp

    @php($department_id == 'SuperAdministrator')
    ? $active = ""
    : $active = "";
    @endphp

    <div class="az-sidebar-body nunito-font">
        <ul class="nav">
            <li class="nav-label">Main Menu</li>


            <li><a href="{{ route('home') }}" class="nav-link mt-3">
                <i class="fa fa-laptop"></i>Dashboard</a></li>

            <li class="nav-item">
                <a href="{{ route('pos.index') }}" class="nav-link with-sub"><i
                        class="fa fa-shopping-cart"></i>Restaurant & Bar</a>
                <ul class="nav-sub">
                    <li class="nav-sub-item"><a href="{{ route('pos.index') }}" class="nav-sub-link">Point of Sale</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('pos.index') }}" class="nav-link with-sub"><i
                        class="fa fa-coffee"></i>Kitchen</a>
                <ul class="nav-sub">
                  
                    <li class="nav-item">
                        <a href="" class="nav-link with-sub">Orders</a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item"><a href="{{ Route('kitchen-orders.index') }}" class="nav-sub-link">Pending Orders</a></li>
                            <li class="nav-sub-item"><a href="{{ Route('kitchen-orders.index') }}" class="nav-sub-link">Completed Orders</a></li>
                            <li class="nav-sub-item"><a href="{{ Route('kitchen-orders.index') }}" class="nav-sub-link">Cancelled Orders</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link with-sub">Kitchen Menu</a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item"><a href="{{ Route('menu-items.index') }}" class="nav-sub-link">Menu Items</a></li>
                            <li class="nav-sub-item"><a href="{{ Route('menu-item-categories.index') }}" class="nav-sub-link">Menu Item Categories</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="fa fa-database"></i>Store & Procurement</a>
                <ul class="nav-sub">
                    <li class="nav-item">
                        <a href="" class="nav-link with-sub">Inventory</a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item"><a href="{{ Route('stock.index') }}"
                                    class="nav-sub-link">Stock</a></li>
                            <li class="nav-sub-item"><a href="{{ Route('purchases.index') }}"
                                    class="nav-sub-link">Purchases</a></li>
                            <li class="nav-sub-item"><a href="{{ Route('damaged-stock-items.index') }}"
                                    class="nav-sub-link">Damaged Stock</a></li>
                            <li class="nav-sub-item"><a href="{{ Route('product-categories.index') }}"
                                    class="nav-sub-link">Stock Categories</a></li>
                        </ul>
                    </li>
                    <li class="nav-sub-item"><a href="{{ Route('suppliers.index') }}" class="nav-sub-link">
                     Suppliers</a>
                    </li>
                    <li class="nav-sub-item"><a href="{{ Route('expenses.index') }}" class="nav-sub-link">
                    Expenses</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="fa fa-clipboard"></i>House Keeping</a>

                <ul class="nav-sub">
                    <li class="nav-sub-item"><a href="{{ Route('expenses.index') }}" class="nav-sub-link">
                            Expenses</a>
                    </li>
                </ul>

            </li>

            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="fa fa-bed"></i>Accomodation</a>

                <ul class="nav-sub">

                    <li class="nav-sub-item"><a href="{{ Route('frequent-contacts.index') }}" class="nav-sub-link">Frequent Contacts</a>
                       </li>

                    <li class="nav-item">
                        <a href="" class="nav-link with-sub">Rooms</a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item"><a href="{{ Route('rooms.index') }}"
                                    class="nav-sub-link">Rooms</a></li>
                            <li class="nav-sub-item"><a href="{{ Route('room_types.index') }}"
                                    class="nav-sub-link">Room types</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="" class="nav-link with-sub">Guests</a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item"><a href="{{ Route('guests.index') }}"
                                    class="nav-sub-link">Guests</a></li>
                            <li class="nav-sub-item"><a href="{{ Route('guest_types.index') }}"
                                    class="nav-sub-link">Guest types</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="" class="nav-link with-sub">Reservations</a>
                        <ul class="nav-sub">
                            <li class="nav-sub-item"><a href="{{ Route('reservations.index') }}"
                                    class="nav-sub-link">All reservations</a></li>
                            <li class="nav-sub-item"><a href="{{ Route('reservations.create') }}"
                                    class="nav-sub-link">Add reservation</a></li>
                        </ul>
                    </li>


                </ul>

            </li>


            <li class="nav-item">
              <a href="" class="nav-link with-sub"><i class="fa fa-users"></i>Human Resource</a>
              <ul class="nav-sub">
               
                <li class="nav-sub-item"><a href="{{ route('departments.index') }}" class="nav-sub-link">Departments</a></li>
                 <li class="nav-sub-item"><a href="{{ route('designations.index') }}" class="nav-sub-link">Designations</a></li>
                 <li class="nav-sub-item"><a href="{{ route('staff.index') }}" class="nav-sub-link">Staff</a></li>
       

                  <li class="nav-item">
                    <a href="" class="nav-link with-sub">Finances</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item"><a href="{{ Route('currencies.index') }}" class="nav-sub-link">Currencies</a></li>
                        <li class="nav-sub-item"><a href="{{ Route('salary.index') }}" class="nav-sub-link">Salaries</a></li>
                        <li class="nav-sub-item"><a href="{{ Route('payments.index') }}" class="nav-sub-link">Payments</a></li>
                    </ul>
                </li>
              </ul>
          </li>

            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="fa fa-chart-area"></i>Reports</a>
                <ul class="nav-sub">
                    <li class="nav-sub-item"><a href="{{ route('sales.index') }}" class="nav-sub-link">Sales Report</a></li>
                    <li class="nav-sub-item"><a href="{{ route('reports.expenses.monthly') }}" class="nav-sub-link">Expense Report</a></li>
                    <li class="nav-sub-item"><a href="{{ route('top-customers') }}" class="nav-sub-link">Revenue Report</a></li>
                    <li class="nav-sub-item"><a href="{{ route('top-customers') }}" class="nav-sub-link">Occupancy Report</a></li>
                    <li class="nav-sub-item"><a href="{{ route('top-customers') }}" class="nav-sub-link">Employee Performance</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="fa fa-balance-scale"></i>Accounting</a>
                <ul class="nav-sub">
                    <li class="nav-sub-item"><a href="{{ Route('accounting.balance_sheet') }}" class="nav-sub-link">Balance Sheet</a> </li>
                    <li class="nav-sub-item"><a href="{{ route('accounting.general_ledger') }}" class="nav-sub-link">General Ledger</a></li>
                    <li class="nav-sub-item"><a href="{{ Route('accounting.cash_flow_statement') }}" class="nav-sub-link">Cash Flow Statement</a> </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="fa fa-cog"></i>Others</a>

                <ul class="nav-sub">
                    <li class="nav-sub-item"><a href="{{ route('companies.create') }}"
                            class="nav-sub-link">Settings</a></li>
                    {{-- <li class="nav-sub-item"><a href="{{ route('mail.index') }}" class="nav-sub-link">Send Email</a></li> --}}
                    <li class="nav-sub-item"><a href="{{ route('logs.index') }}" class="nav-sub-link"> Audit
                            Trail</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>


<div class="az-content az-content-dashboard-five">

    @include('layouts.header')

    <div class="az-content-body">
        @yield('content')
    </div>
    @include('layouts.footer')
</div>
