<div class="az-sidebar bg-primary-dark">
    <div class="az-sidebar-loggedin nunito-font">
        <div class="az-img-user user-img">

            @isset(Auth::user()->image)
                <img src="{{ Storage::disk('public')->url(Auth::user()->image) }}" alt="Profile Image">
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

    <div class="az-sidebar-body nunito-font">
        <ul class="nav">
            <li class="nav-label">Main Menu</li>

            @haspermission(config('permissions')['view_dashboard'])
                <li><a href="{{ route('home') }}" class="nav-link mt-3"><i class="fa fa-laptop"></i>Dashboard</a></li>
            @endhaspermission

            <li class="nav-item">
                <a href="{{ route('pos.index') }}" class="nav-link with-sub"><i
                        class="fa fa-shopping-cart"></i>Restaurant & Bar</a>
                <ul class="nav-sub">
                    @haspermission(config('permissions')['view_pos'])
                        <li class="nav-sub-item"><a href="{{ route('pos.index') }}" class="nav-sub-link">Point of Sale</a></li>
                        <li class="nav-sub-item"><a href="{{ route('sales.index') }}" class="nav-sub-link">Sales</a></li>

                    @endhaspermission

                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('pos.index') }}" class="nav-link with-sub"><i class="fa fa-coffee"></i>Kitchen</a>

                <ul class="nav-sub">

                    @haspermission(config('permissions')['view_kitchen_orders'])
                        <li class="nav-item">
                            <a href="" class="nav-link with-sub">Orders</a>
                            <ul class="nav-sub">
                                <li class="nav-sub-item"><a href="{{ Route('kitchen-orders.index') }}"
                                        class="nav-sub-link">New Order</a></li>
                                <li class="nav-sub-item"><a href="{{ Route('kitchen-orders.index') }}"
                                        class="nav-sub-link">In Progress</a></li>
                                <li class="nav-sub-item"><a href="{{ Route('kitchen-orders.index') }}"
                                        class="nav-sub-link">Completed Orders</a></li>
                                <li class="nav-sub-item"><a href="{{ Route('kitchen-orders.index') }}"
                                        class="nav-sub-link">Cancelled Orders</a></li>
                                <li class="nav-sub-item"><a href="{{ Route('kitchen-order-history.index') }}"
                                        class="nav-sub-link">Order History</a></li>
                            </ul>
                        </li>
                    @endhaspermission


                    <li class="nav-item">
                        <a href="" class="nav-link with-sub">Kitchen Menu</a>
                        <ul class="nav-sub">
                            @haspermission(config('permissions')['view_kitchen_menu_items'])
                                <li class="nav-sub-item"><a href="{{ Route('menu-items.index') }}"
                                        class="nav-sub-link">Menu Items</a></li>
                            @endhaspermission

                            @haspermission(config('permissions')['view_kitchen_menu_item_categories'])
                                <li class="nav-sub-item"><a href="{{ Route('menu-item-categories.index') }}"
                                        class="nav-sub-link">Menu Item Categories</a></li>
                            @endhaspermission
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
                            @haspermission(config('permissions')['view_stock'])
                                <li class="nav-sub-item"><a href="{{ Route('stock.index') }}"
                                        class="nav-sub-link">Stock</a></li>
                            @endhaspermission
                            @haspermission(config('permissions')['view_purchases'])
                                <li class="nav-sub-item"><a href="{{ Route('purchases.index') }}"
                                        class="nav-sub-link">Purchases</a></li>
                            @endhaspermission

                            @haspermission(config('permissions')['view_damages'])
                                <li class="nav-sub-item"><a href="{{ Route('damaged-stock-items.index') }}"
                                        class="nav-sub-link">Damaged Stock</a></li>
                            @endhaspermission

                            @haspermission(config('permissions')['view_product_categories'])
                                <li class="nav-sub-item"><a href="{{ Route('product-categories.index') }}"
                                        class="nav-sub-link">Stock Categories</a></li>
                            @endhaspermission

                        </ul>
                    </li>
                    @haspermission(config('permissions')['view_suppliers'])
                        <li class="nav-sub-item"><a href="{{ Route('suppliers.index') }}"
                                class="nav-sub-link">Suppliers</a> </li>
                    @endhaspermission

                    @haspermission(config('permissions')['view_expenses'])
                        <li class="nav-sub-item"><a href="{{ Route('expenses.index') }}" class="nav-sub-link"> Expenses</a>
                        </li>
                    @endhaspermission

                </ul>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="fa fa-clipboard"></i>House Keeping</a>

                <ul class="nav-sub">
                    @haspermission(config('permissions')['view_expenses'])
                        <li class="nav-sub-item"><a href="{{ Route('expenses.index') }}" class="nav-sub-link">Expenses</a>
                        </li>
                    @endhaspermission

                </ul>

            </li>

            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="fa fa-bed"></i>Accomodation</a>

                <ul class="nav-sub">

                    @haspermission(config('permissions')['view_frequent_contacts'])
                        <li class="nav-sub-item"><a href="{{ Route('frequent-contacts.index') }}"
                                class="nav-sub-link">Frequent Contacts</a> </li>
                    @endhaspermission

                    <li class="nav-item">

                        @haspermission(config('permissions')['view_rooms'])
                            <a href="" class="nav-link with-sub">Rooms</a>
                            <ul class="nav-sub">
                                <li class="nav-sub-item"><a href="{{ Route('rooms.index') }}"
                                        class="nav-sub-link">Rooms</a></li>

                                <li class="nav-sub-item"><a href="{{ Route('room_types.index') }}"
                                        class="nav-sub-link">Room types</a>
                                </li>

                            </ul>
                        @endhaspermission

                    </li>

                    <li class="nav-item">
                        <a href="" class="nav-link with-sub">Guests</a>
                        <ul class="nav-sub">
                            @haspermission(config('permissions')['view_guests'])
                                <li class="nav-sub-item"><a href="{{ Route('guests.index') }}"
                                        class="nav-sub-link">Guests</a></li>
                            @endhaspermission

                            @haspermission(config('permissions')['view_guest_types'])
                                <li class="nav-sub-item"><a href="{{ Route('guest_types.index') }}"
                                        class="nav-sub-link">Guest types</a></li>
                            @endhaspermission

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="" class="nav-link with-sub">Reservations</a>
                        <ul class="nav-sub">
                            @haspermission(config('permissions')['view_reservations'])
                                <li class="nav-sub-item"><a href="{{ Route('reservations.index') }}"
                                        class="nav-sub-link">All reservations</a></li>
                            @endhaspermission

                            @haspermission(config('permissions')['create_reservations'])
                                <li class="nav-sub-item"><a href="{{ Route('reservations.create') }}"
                                        class="nav-sub-link">Add reservation</a></li>
                            @endhaspermission

                        </ul>
                    </li>


                </ul>

            </li>


            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="fa fa-users"></i>Human Resource</a>
                <ul class="nav-sub">

                    @haspermission(config('permissions')['view_departments'])
                        <li class="nav-sub-item"><a href="{{ route('departments.index') }}"
                                class="nav-sub-link">Departments</a></li>
                    @endhaspermission

                    @haspermission(config('permissions')['view_designations'])
                        <li class="nav-sub-item"><a href="{{ route('designations.index') }}"
                                class="nav-sub-link">Designations</a></li>
                    @endhaspermission

                    @haspermission(config('permissions')['view_staff'])
                        <li class="nav-sub-item"><a href="{{ route('staff.index') }}" class="nav-sub-link">Staff</a>
                        </li>
                    @endhaspermission

                    @haspermission(config('permissions')['view_staff_permissions'])
                        <li class="nav-sub-item"><a href="{{ route('staff-permissions.index') }}"
                                class="nav-sub-link">Staff Permissions</a>
                        </li>
                    @endhaspermission


                    <li class="nav-item">
                        <a href="" class="nav-link with-sub">Finances</a>
                        <ul class="nav-sub">
                            @haspermission(config('permissions')['view_currencies'])
                                <li class="nav-sub-item"><a href="{{ Route('currencies.index') }}"
                                        class="nav-sub-link">Currencies</a></li>
                            @endhaspermission

                            @haspermission(config('permissions')['view_salaries'])
                                <li class="nav-sub-item"><a href="{{ Route('salary.index') }}"
                                        class="nav-sub-link">Salaries</a></li>
                            @endhaspermission

                            @haspermission(config('permissions')['view_payments'])
                                <li class="nav-sub-item"><a href="{{ Route('payments.index') }}"
                                        class="nav-sub-link">Payments</a></li>
                            @endhaspermission

                        </ul>
                    </li>
                </ul>
            </li>

            @haspermission(config('permissions')['view_reports'])
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="fa fa-chart-area"></i>Reports</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item"><a href="{{ route('sales.index') }}" class="nav-sub-link">Sales
                                Report</a></li>
                        <li class="nav-sub-item"><a href="{{ route('reports.expenses.monthly') }}"
                                class="nav-sub-link">Expense Report</a></li>
                        <li class="nav-sub-item"><a href="{{ route('top-customers') }}" class="nav-sub-link">Revenue
                                Report</a></li>
                        <li class="nav-sub-item"><a href="{{ route('top-customers') }}" class="nav-sub-link">Occupancy
                                Report</a></li>
                        <li class="nav-sub-item"><a href="{{ route('top-customers') }}" class="nav-sub-link">Employee
                                Performance</a></li>
                    </ul>
                </li>
            @endhaspermission


            @haspermission(config('permissions')['view_accounting'])
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="fa fa-balance-scale"></i>Accounting</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item"><a href="{{ Route('accounting.balance_sheet') }}"
                                class="nav-sub-link">Balance Sheet</a> </li>
                        <li class="nav-sub-item"><a href="{{ route('accounting.general_ledger') }}"
                                class="nav-sub-link">General Ledger</a></li>
                        <li class="nav-sub-item"><a href="{{ Route('accounting.cash_flow_statement') }}"
                                class="nav-sub-link">Cash Flow Statement</a> </li>
                        <li class="nav-sub-item"><a href="{{ Route('accounting.profit_and_loss') }}"
                                class="nav-sub-link">Profit and Loss Statement</a> </li>
                    </ul>
                </li>
            @endhaspermission


            <li class="nav-item">
                <a href="" class="nav-link with-sub"><i class="fa fa-cog"></i>Others</a>

                <ul class="nav-sub">
                    @haspermission(config('permissions')['view_settings'])
                        <li class="nav-sub-item"><a href="{{ route('companies.create') }}"
                                class="nav-sub-link">Settings</a></li>
                    @endhaspermission

                    @haspermission(config('permissions')['view_audit_trail'])
                        <li class="nav-sub-item"><a href="{{ route('logs.index') }}" class="nav-sub-link"> Audit
                                Trail</a></li>
                    @endhaspermission
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
