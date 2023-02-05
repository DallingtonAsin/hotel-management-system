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
                <li><a href="{{ route('home') }}" class="nav-link mt-3"><i class="fa fa-home"></i>Dashboard</a></li>
            @endhaspermission

            @haspermission(config('permissions')['access_bar'])
                <li class="nav-item">
                    <a href="{{ route('pos.index') }}" class="nav-link with-sub"><i
                            class="fa fa-glass ml-1"></i>Bar</a>
                    <ul class="nav-sub">
                        @haspermission(config('permissions')['view_pos'])
                            <li class="nav-sub-item"><a href="{{ route('pos.index') }}" class="nav-sub-link"><i
                                        class="fa fa-laptop pr-1"></i>Point of Sale</a></li>
                         @endhaspermission

                         @haspermission(config('permissions')['view_sales'])
                            <li class="nav-sub-item"><a href="{{ route('sales.index') }}" class="nav-sub-link"><i
                                        class="fa fa-cubes pr-1"></i>Sales</a></li>
                        @endhaspermission
                    </ul>
                </li>
            @endhaspermission


            @haspermission(config('permissions')['access_restaurant'])
                <li class="nav-item">
                    <a href="{{ route('pos.index') }}" class="nav-link with-sub"><i class="fa fa-coffee"></i>Restaurant</a>

                    <ul class="nav-sub">

                        @haspermission(config('permissions')['view_kitchen_orders'])
                            <li class="nav-item">
                                <a href="" class="nav-link with-sub"><i class="fa fa-shopping-basket pr-1"></i>Kitchen
                                    Orders</a>
                                <ul class="nav-sub">
                                    <li class="nav-sub-item"><a href="{{ route('kitchen-orders.index') }}"
                                            class="nav-sub-link">New Order</a></li>
                                    <li class="nav-sub-item"><a
                                            href="{{ route('orders.status', ['status' => config('kitchen-order-statuses')['pending']]) }}"
                                            class="nav-sub-link">Pending Orders</a></li>
                                    <li class="nav-sub-item"><a
                                            href="{{ route('orders.status', ['status' => config('kitchen-order-statuses')['completed']]) }}"
                                            class="nav-sub-link">Completed Orders</a></li>
                                    <li class="nav-sub-item"><a
                                            href="{{ route('orders.status', ['status' => config('kitchen-order-statuses')['cancelled']]) }}"
                                            class="nav-sub-link">Cancelled Orders</a></li>
                                    <li class="nav-sub-item"><a href="{{ route('kitchen-order-history.index') }}"
                                            class="nav-sub-link">All Orders</a></li>
                                </ul>
                            </li>
                        @endhaspermission


                        <li class="nav-item">
                            <a href="" class="nav-link with-sub"><i class="fa fa-list-alt pr-1"></i>Kitchen Menu</a>
                            <ul class="nav-sub">
                                @haspermission(config('permissions')['view_kitchen_menu_items'])
                                    <li class="nav-sub-item"><a href="{{ route('menu-items.index') }}"
                                            class="nav-sub-link">Menu Items</a></li>
                                @endhaspermission

                                @haspermission(config('permissions')['view_kitchen_menu_item_categories'])
                                    <li class="nav-sub-item"><a href="{{ route('menu-item-categories.index') }}"
                                            class="nav-sub-link">Menu Item Categories</a></li>
                                @endhaspermission
                            </ul>
                        </li>
                    </ul>
                </li>
            @endhaspermission


            @haspermission(config('permissions')['access_store'])
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="fa fa-database"></i>Store & Procurement</a>
                    <ul class="nav-sub">
                        <li class="nav-item">
                            <a href="" class="nav-link with-sub"><i class="fa fa-cube pr-1"></i>Commodites</a>
                            <ul class="nav-sub">
                                @haspermission(config('permissions')['view_stock'])
                                    <li class="nav-sub-item"><a href="{{ route('goods.index') }}"
                                            class="nav-sub-link">Goods</a></li>
                                @endhaspermission
                                @haspermission(config('permissions')['view_stock'])
                                    <li class="nav-sub-item"><a href="{{ route('commodity-categories.index') }}"
                                            class="nav-sub-link">Commodity Categories</a></li>
                                @endhaspermission

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link with-sub"><i class="fa fa-database pr-1"></i>Inventory</a>
                            <ul class="nav-sub">
                                @haspermission(config('permissions')['view_stock'])
                                    <li class="nav-sub-item"><a href="{{ route('stock.index') }}"
                                            class="nav-sub-link">Stock</a></li>
                                @endhaspermission

                                {{-- @haspermission(config('permissions')['view_purchases'])
                                <li class="nav-sub-item"><a href="{{ route('purchases.index') }}"
                                        class="nav-sub-link">Purchases</a></li>
                            @endhaspermission --}}

                                @haspermission(config('permissions')['view_damages'])
                                    <li class="nav-sub-item"><a href="{{ route('damaged-stock-items.index') }}"
                                            class="nav-sub-link">Damaged Stock</a></li>
                                @endhaspermission

                                {{-- @haspermission(config('permissions')['view_product_categories'])
                                    <li class="nav-sub-item"><a href="{{ route('product-categories.index') }}"
                                            class="nav-sub-link">Stock Categories</a></li>
                                @endhaspermission --}}

                            </ul>
                        </li>
                        @haspermission(config('permissions')['view_suppliers'])
                            <li class="nav-sub-item"><a href="{{ route('suppliers.index') }}" class="nav-sub-link"><i
                                        class="fa fa-users pr-2"></i>Suppliers</a> </li>
                        @endhaspermission

                        @haspermission(config('permissions')['view_expenses'])
                            <li class="nav-item">
                                <a href="" class="nav-link with-sub"><i
                                        class="fa fa-times-circle pr-1"></i>Expenses</a>
                                <ul class="nav-sub">
                                    @haspermission(config('permissions')['view_expenses'])
                                        <li class="nav-sub-item"><a href="{{ route('expenses.index') }}"
                                                class="nav-sub-link">Expenses</a></li>
                                    @endhaspermission
                                    @haspermission(config('permissions')['view_expenses'])
                                        <li class="nav-sub-item"><a href="{{ route('expense-types.index') }}"
                                                class="nav-sub-link">Expenses Categories</a></li>
                                    @endhaspermission

                                </ul>
                            </li>
                        @endhaspermission

                    </ul>
                </li>
            @endhaspermission


            @haspermission(config('permissions')['access_house_keeping'])
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="fa fa-clipboard"></i>House Keeping</a>

                    <ul class="nav-sub">
                        @haspermission(config('permissions')['view_expenses'])
                            <li class="nav-sub-item"><a href="{{ route('expenses.index') }}" class="nav-sub-link"><i
                                        class="fa fa-times-circle pr-1"></i>Expenses</a>
                            </li>
                        @endhaspermission
                    </ul>
                </li>
            @endhaspermission


            @haspermission(config('permissions')['access_accomodation'])
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="fa fa-bed"></i>Accomodation</a>
                    <ul class="nav-sub">
                        <li class="nav-item">

                            @haspermission(config('permissions')['view_rooms'])
                                <a href="" class="nav-link with-sub"><i class="fa fa-bed pr-1"></i>Rooms</a>
                                <ul class="nav-sub">
                                    <li class="nav-sub-item"><a href="{{ route('rooms.index') }}"
                                            class="nav-sub-link">Rooms</a></li>

                                    <li class="nav-sub-item"><a href="{{ route('room_types.index') }}"
                                            class="nav-sub-link">Room types</a>
                                    </li>

                                </ul>
                            @endhaspermission

                        </li>

                        @haspermission(config('permissions')['view_guests'])
                        <li class="nav-item">
                            <a href="" class="nav-link with-sub"><i class="fa fa-users pr-1"></i>Guests</a>
                            <ul class="nav-sub">
                                    <li class="nav-sub-item"><a href="{{ route('guests.index') }}" class="nav-sub-link">Guests</a></li>
                                @haspermission(config('permissions')['view_guest_types'])
                                    <li class="nav-sub-item"><a href="{{ route('guest_types.index') }}"  class="nav-sub-link">Guest types</a></li>
                                @endhaspermission

                                @haspermission(config('permissions')['view_frequent_contacts'])
                                    <li class="nav-sub-item"><a href="{{ route('frequent-contacts.index') }}"  class="nav-sub-link">Frequent contacts</a> </li>
                                @endhaspermission

                            </ul>
                        </li>
                        @endhaspermission

                        @haspermission(config('permissions')['view_reservations'])
                        <li class="nav-item">
                            <a href="" class="nav-link with-sub"><i class="fa fa-bold pr-1"></i>Reservations</a>
                            <ul class="nav-sub">
                                    <li class="nav-sub-item"><a href="{{ route('reservations.status', ['status' => config('reservation-statuses')['pending']]) }}" class="nav-sub-link"><i class="fa fa-clock pr-1"></i>Pending</a></li>
                                    <li class="nav-sub-item"><a href="{{ route('reservations.status', ['status' => config('reservation-statuses')['completed']]) }}" class="nav-sub-link"><i class="fa fa-check-circle pr-1"></i>Paid</a></li>
                                    <li class="nav-sub-item"><a href="{{ route('reservations.status', ['status' => config('reservation-statuses')['cancelled']]) }}" class="nav-sub-link"><i class="fa fa-times-circle pr-1"></i>Cancelled</a></li>
                                    <li class="nav-sub-item"><a href="{{ route('reservations.index') }}" class="nav-sub-link"><i class="fa fa-list pr-1"></i>All reservations</a></li>

                                @haspermission(config('permissions')['create_reservations'])
                                    <li class="nav-sub-item"><a href="{{ route('reservations.create') }}"
                                            class="nav-sub-link"><i class="fa fa-plus-circle pr-1"></i>Add reservation</a></li>
                                @endhaspermission

                            </ul>
                        </li>
                        @endhaspermission

                    </ul>
                </li>
            @endhaspermission


            @haspermission(config('permissions')['access_HR'])
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="fa fa-users"></i>Human Resource</a>
                    <ul class="nav-sub">

                        @haspermission(config('permissions')['view_departments'])
                            <li class="nav-sub-item"><a href="{{ route('departments.index') }}" class="nav-sub-link"><i
                                        class="fa fa-user-plus pr-1"></i>Departments</a></li>
                        @endhaspermission

                        @haspermission(config('permissions')['view_designations'])
                            <li class="nav-sub-item"><a href="{{ route('designations.index') }}" class="nav-sub-link"><i
                                        class="fa fa-user-circle pr-1"></i>Designations</a></li>
                        @endhaspermission

                        @haspermission(config('permissions')['view_staff'])
                            <li class="nav-sub-item"><a href="{{ route('staff.index') }}" class="nav-sub-link"><i
                                        class="fa fa-users pr-1"></i>Staff</a>
                            </li>
                        @endhaspermission

                        @haspermission(config('permissions')['view_staff_permissions'])
                            <li class="nav-sub-item"><a href="{{ route('staff-permissions.index') }}"
                                    class="nav-sub-link"><i class="fa fa-lock pr-1"></i>Staff Permissions</a>
                            </li>
                        @endhaspermission


                        @haspermission(config('permissions')['view_payments'])
                        <li class="nav-item">
                            <a href="" class="nav-link with-sub"><i
                                    class="fa fa-credit-card pr-1"></i>Finances</a>
                            <ul class="nav-sub">
                                @haspermission(config('permissions')['view_currencies'])
                                    <li class="nav-sub-item"><a href="{{ route('currencies.index') }}"
                                            class="nav-sub-link">Currencies</a></li>
                                @endhaspermission

                                @haspermission(config('permissions')['view_payments'])
                                    <li class="nav-sub-item"><a href="{{ route('staff-payments.index') }}"
                                            class="nav-sub-link">Staff Payments</a></li>
                                @endhaspermission

                                @haspermission(config('permissions')['view_salaries'])
                                    <li class="nav-sub-item"><a href="{{ route('payment-categories.index') }}"
                                            class="nav-sub-link">Payment Categories</a></li>
                                @endhaspermission

                            </ul>
                        </li>
                        @endhaspermission
                        
                    </ul>
                </li>
            @endhaspermission

            @haspermission(config('permissions')['access_accounting'])
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="fa fa-balance-scale"></i>Accounting</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item"><a href="{{ route('accounting.balance_sheet') }}"
                                class="nav-sub-link"><i class="fa fa-table pr-1"></i>Balance Sheet</a> </li>
                        <li class="nav-sub-item"><a href="{{ route('accounting.general_ledger') }}"
                                class="nav-sub-link"><i class="fa fa-bar-chart pr-1"></i>General Ledger</a></li>
                        <li class="nav-sub-item"><a href="{{ route('accounting.cash_flow_statement') }}"
                                class="nav-sub-link"><i class="fa fa-line-chart pr-1"></i>Cash Flow Statement</a> </li>
                        <li class="nav-sub-item"><a href="{{ route('accounting.profit_and_loss') }}"
                                class="nav-sub-link"><i class="fa fa-pie-chart pr-1"></i>Profit & Loss Statement</a> </li>
                    </ul>
                </li>
            @endhaspermission

            @haspermission(config('permissions')['view_reports'])
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="fa fa-bar-chart"></i>Reports</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item"><a href="{{ route('sales.index') }}" class="nav-sub-link"><i class="fa fa-truck pr-3"></i>Sales</a></li>
                        <li class="nav-sub-item"><a href="{{ route('reports.expenses.monthly') }}" class="nav-sub-link"><i class="fa fa-minus-circle pr-3"></i>Expenses</a></li>
                        <li class="nav-item">
                            <a href="" class="nav-link with-sub"><i class="fa fa-money"></i>Revenue</a>
                            <ul class="nav-sub">
                                <li class="nav-sub-item"><a href="{{ route('reports.revenue.bar.monthly') }}" class="nav-sub-link"><i class="fa fa-bar-chart pr-1"></i>Bar</a></li>
                                <li class="nav-sub-item"><a href="{{ route('reports.revenue.restaurant.monthly') }}" class="nav-sub-link"><i class="fa fa-pie-chart pr-1"></i>Restaurant</a></li>
                                    <li class="nav-sub-item"><a href="{{ route('reports.revenue.accomodation.monthly') }}" class="nav-sub-link"><i class="fa fa-line-chart pr-1"></i>Accomodation</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endhaspermission


            @haspermission(config('permissions')['access_other_system_features'])
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="fa fa-cog"></i>Others</a>

                    <ul class="nav-sub">
                        @haspermission(config('permissions')['view_settings'])
                            <li class="nav-sub-item"><a href="{{ route('companies.create') }}" class="nav-sub-link"><i
                                        class="fa fa-toggle-on pr-1"></i>Settings</a></li>
                        @endhaspermission

                        @haspermission(config('permissions')['view_audit_trail'])
                            <li class="nav-sub-item"><a href="{{ route('logs.index') }}" class="nav-sub-link"><i
                                        class="fa fa-cloud pr-1"></i> Audit
                                    Trail</a></li>
                        @endhaspermission
                    </ul>
                </li>
            @endhaspermission


        </ul>
    </div>
</div>
