<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Accomodation Controllers
use App\Http\Controllers\Accomodation\FrequentContactController;
use App\Http\Controllers\Accomodation\GuestController;
use App\Http\Controllers\Accomodation\GuestTypeController;
use App\Http\Controllers\Accomodation\ReservationController;
use App\Http\Controllers\Accomodation\RoomController;
use App\Http\Controllers\Accomodation\RoomTypeController;

// Accounting Controllers
use App\Http\Controllers\Accounting\AccountingController;
use App\Http\Controllers\Accounting\ExpensesController;

// Audit Controllers
use App\Http\Controllers\Audit\LogsController;

// Finances Controllers
use App\Http\Controllers\Finances\CurrencyController;
use App\Http\Controllers\Finances\PaymentController;
use App\Http\Controllers\Finances\SalaryController;

// Home Controllers
use App\Http\Controllers\Home\HomeController;

// HR Controllers
use App\Http\Controllers\HR\DepartmentController;
use App\Http\Controllers\HR\DesignationController;
use App\Http\Controllers\HR\StaffMemberController;
use App\Http\Controllers\HR\StaffPermissionController;


// Inventory Controllers
use App\Http\Controllers\Inventory\DamagesController;
use App\Http\Controllers\Inventory\PurchasesController;
use App\Http\Controllers\Inventory\StockCategoryController;
use App\Http\Controllers\Inventory\StockController;

// Invoice Controllers
use App\Http\Controllers\Invoices\InvoiceController;
use App\Http\Controllers\Invoices\InvoiceGuestController;

// Kitchen Controllers
use App\Http\Controllers\Kitchen\KitchenOrderController;
use App\Http\Controllers\Kitchen\MenuItemController;
use App\Http\Controllers\Kitchen\KitchenMenuItemCategoryController;

// Messages Controllers
use App\Http\Controllers\Messages\CalendarController;
use App\Http\Controllers\Messages\MailController;
use App\Http\Controllers\Messages\NotificationController;
use App\Http\Controllers\Messages\SmsController;

// Pos Controllers
use App\Http\Controllers\Pos\CartController;
use App\Http\Controllers\Pos\SalesController;

// Reports Controllers
use App\Http\Controllers\Reports\ReportsController;

// Settings Controllers
use App\Http\Controllers\Settings\SettingsController;

// User Controllers
use App\Http\Controllers\User\CustomersController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SuppliersController;
use App\Http\Controllers\User\UserController;

// Authentication Controllers
use App\Http\Controllers\Auth\CustomLoginController;



// Login Routes
Auth::routes();
Route::get('', [CustomLoginController::class, 'retryLogin'])->name('re-login');
Route::post('user/validate', [CustomLoginController::class, 'authenticate'])->name('authenticate');
Route::get('sign-out', [CustomLoginController::class, 'logout'])->name('signout');
Route::group(['middleware' => 'OTPlayer'], function () {
	Route::post('login/verifyOTP', [CustomLoginController::class, 'VerifyUserOTPRequest'])->name('verifyOTP');
	Route::get('login/OTP', [CustomLoginController::class, 'getOTPPage']);
});


// Accomodation Routes
Route::get('room-types/ajax', [RoomTypeController::class, 'fetchRoomTypesAjax'])->name('room_types.ajax.fetch');
Route::get('rooms/ajax', [RoomController::class, 'fetchRoomsAjax'])->name('rooms.ajax.fetch');
Route::get('rooms/fetch/ajax', [RoomController::class, 'RoomsDataTable'])->name('rooms.index.ajax');
Route::get('rooms-types/fetch/ajax', [RoomTypeController::class, 'RoomTypesDataTable'])->name('roomstypes.index.ajax');
Route::post('rooms/ajax/suggestions', [RoomController::class, 'suggestRooms'])->name('rooms.ajax.suggest');
Route::get('rooms/occupant/fetch/{room_number}', [RoomController::class, 'getRoomOccupantDetails'])->name('room.occupant.ajax.fetch');
Route::post('rooms/ajax/price', [RoomController::class, 'getRoomPriceAjax'])->name('room.price.ajax.fetch');

Route::get('guests-types/fetch/ajax', [GuestTypeController::class, 'getGuestTypesDataTable'])->name('guesttypes.index.ajax');
Route::get('guests/fetch/ajax', [GuestController::class, 'getGuests'])->name('guests.index.ajax');
Route::get('guests/ajax', [GuestController::class, 'fetchGuestsAjax'])->name('guests.ajax.fetch');
Route::get('reservations/fetch/ajax', [ReservationController::class, 'getReservations'])->name('reservations.index.ajax');
Route::get('reservations/frequent-contacts/fetch/ajax', [FrequentContactController::class, 'getFrequentContactsDataTable'])->name('frequent-contacts.index.ajax');
Route::get('reservations/frequent-contacts/ajax', [FrequentContactController::class, 'fetchFrequentContactsAjax'])->name('frequent-contacts.ajax.fetch');
Route::get('reservations/fetch/{freq_contact_id}', [FrequentContactController::class, 'fetchFreqContactDetailsById'])->name('frequent-contact-details.ajax.fetch');



// Accounting Routes
Route::get('accounting/balance-sheet', [AccountingController::class, 'generateBalanceSheet'])->name('accounting.balance_sheet');
Route::get('accounting/cash-flow-statement', [AccountingController::class, 'generateCashFlowStatement'])->name('accounting.cash_flow_statement');
Route::get('accounting/general-ledger', [AccountingController::class, 'generateGeneralLedger'])->name('accounting.general_ledger');
Route::get('accounting/profit-and-loss', [AccountingController::class, 'generateProfitAndLoss'])->name('accounting.profit_and_loss');

Route::post('expenses/import-expenses', [ExpensesController::class, 'importExpenses'])->name('expenses.import');
Route::get('expenses/export-expenses', [ExpensesController::class, 'exportExpenses'])->name('expenses.export');
Route::post('expenses/remove/selected', [ExpensesController::class, 'RemoveSelected'])->name('selected-expenses.remove');
Route::post('expenses/deleteAll', [ExpensesController::class, 'deleteAllExpenses'])->name('expenses.truncate');
Route::get('expenses/get-data', [ExpensesController::class, 'GetExpenses'])->name('get-expenses');


// Audit Routes
Route::get('logs/get-data', [LogsController::class, 'GetLogs'])->name('get-logs');
Route::post('logs/truncate', [LogsController::class, 'truncateLogs'])->name('logs.truncate');


// Finance Routes
Route::get('payments/fetch/ajax', [PaymentController::class, 'getPaymentsDataTable'])->name('payments.index.ajax');
Route::get('salaries/fetch/ajax', [SalaryController::class, 'getSalariesDataTable'])->name('salaries.index.ajax');
Route::get('currencies/fetch/ajax', [CurrencyController::class, 'getCurrencyDataTable'])->name('currencies.index.ajax');
Route::get('currencies/ajax', [CurrencyController::class, 'fetchCurrenciesAjax'])->name('currencies.ajax.fetch');


// Home Routes
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('overview', [HomeController::class, 'overview'])->name('overview');


// HR Routes
Route::get('departments/ajax', [DepartmentController::class, 'fetchDepartmentsAjax'])->name('departments.ajax.fetch');
Route::get('departments/fetch/ajax', [DepartmentController::class, 'getDepartmentsDataTable'])->name('departments.index.ajax');
Route::get('designations/fetch/{department_id}', [DesignationController::class, 'fetchDesignationsByDepartment'])->name('designations.ajax.fetch');
Route::get('designations/index/ajax', [DesignationController::class, 'getDesignationsDataTable'])->name('designations.index.fetch');
Route::get('designations/fetch/ajax', [DesignationController::class, 'getDesignationsDataTable'])->name('designations.index.ajax');
Route::get('staff-members/ajax', [UserController::class, 'fetchStaffAjax'])->name('staff.ajax.fetch');
Route::get('staff/fetch/ajax', [StaffMemberController::class, 'GetStaffMemebers'])->name('staff.index.ajax');
Route::get('staff-members/permissions/ajax', [StaffPermissionController::class, 'getStaffPermissions'])->name('staff.permissions.ajax.fetch');
Route::post('staff-members/permissions/store', [StaffPermissionController::class, 'store'])->name('permissions.assign');
Route::get('staff-members/{staff_id}/permissions/edit', [StaffPermissionController::class, 'edit'])->name('staff.permissions.edit');
Route::put('staff-members/{staff}/permissions/update', [StaffPermissionController::class, 'update'])->name('staff.permissions.update');
Route::get('staff-member/permission/{permission_name}', [StaffPermissionController::class, 'hasPermission'])->name('staff.permissions.verify');



// Inventory Routes
Route::get('stock/get-data', [StockController::class, 'GetStock'])->name('get-stock');
Route::get('stock/fetch', [StockController::class, 'fetchStockItemsAjax'])->name('stock.ajax.fetch');
Route::get('stock/export-stock', [StockController::class, 'exportStock'])->name('stock.export');
Route::post('stock/remove/selected', [StockController::class, 'RemoveSelected'])->name('selected-stock.remove');
Route::post('stock/import-stock', [StockController::class, 'importStock'])->name('stock.import');
Route::post('stock/search/item', [DamagesController::class, 'searchItem'])->name('stock-item.search');
Route::post('stock/deleteAll', [StockController::class, 'deleteAllStockItems'])->name('stock.truncate');
Route::post('damaged-stock-items/deleteAll', [DamagesController::class, 'deleteAllDamages'])->name('damages.truncate');
Route::post('damaged-stock-items/import-damages', [DamagesController::class, 'importDamages'])->name('damages.import');
Route::get('damaged-stock-items/export-damages', [DamagesController::class, 'exportDamages'])->name('damages.export');
Route::post('damaged-stock-items/remove/selected', [DamagesController::class, 'RemoveSelected'])->name('selected-damages.remove');
Route::get('damaged-stock-items/get-data', [DamagesController::class, 'GetDamages'])->name('get-damages');
Route::get('product-categories/load/', [StockCategoryController::class, 'StockCatAjaxIndex'])->name('get-stockItems');
Route::post('product-categories/import-categories', [StockCategoryController::class, 'importCategories'])->name('categories.import');
Route::get('product-categories/export-categories', [StockCategoryController::class, 'exportCategories'])->name('categories.export');
Route::post('product-categories/deleteAll', [StockCategoryController::class, 'deleteAllStockCategories'])->name('categories.truncate');
Route::post('product-categories/remove/selected', [StockCategoryController::class, 'RemoveSelected'])->name('selected-stockcats.remove');
Route::post('purchases/import-purchases', [SuppliersController::class, 'importPurchasedItems'])->name('purchases.import');
Route::post('purchases/remove/selected', [PurchasesController::class, 'RemoveSelected'])->name('selected-purchases.remove');
Route::get('purchases/get/', [PurchasesController::class, 'GetPurchases'])->name('get-purchases');
Route::post('purchases/deleteAll', [PurchasesController::class, 'deleteAllPurchases'])->name('purchases.truncate');


// Invoice Routes
Route::get('invoice/reservation/download/{id}', [InvoiceController::class, 'downloadReservationInvoice'])->name('invoice.generate');
Route::post('invoice/kitchen-order/download/{id}', [InvoiceController::class, 'downloadKitchenOrderInvoice'])->name('kitchen-order.invoice.generate');

// Kitchen Routes
Route::get('kitchen/menu-items/ajax', [MenuItemController::class, 'fetchMenuItemsAjax'])->name('kitchen-menu-items.ajax.fetch');
Route::get('kitchen/menu-item/price/{menu_item_id}', [MenuItemController::class, 'getMenuItemPrice'])->name('menu-item.price.ajax.fetch');
Route::get('kitchen/item/{menu_item_id}', [MenuItemController::class, 'getMenuItem'])->name('menu-item.get');
Route::get('kitchen/order/fetch/ajax', [KitchenOrderController::class, 'getKitchenOrdersDataTable'])->name('kitchen_orders.index.ajax');
Route::put('kitchen/order/update/{id}', [KitchenOrderController::class, 'changeKitchenOrderStatus'])->name('kitchen-order.status.update');
Route::post('kitchen/order/post', [KitchenOrderController::class, 'storeKitchenOrder'])->name('kitchen-order.submit');
Route::get('kitchen/menu-items/fetch/ajax', [MenuItemController::class, 'getMenuItemsDataTable'])->name('menu-items.index.ajax');
Route::get('kitchen/menu-items-categories/fetch/ajax', [KitchenMenuItemCategoryController::class, 'getKitchenMenuCategoriesOrdersDataTable'])->name('menu-item-categories.index.ajax');
Route::get('kitchen/menu-item-categories/ajax', [KitchenMenuItemCategoryController::class, 'fetchMenuItemCatAjax'])->name('menu-item-categories.ajax.fetch');


// Messages Routes
Route::post('notifications/get', [NotificationController::class, '@GetOtherNotifications'])->name('unreadNotifications');
Route::post('notification/unreadEmailNotifications', [NotificationController::class, '@GetUnReadEmailNotifications'])->name('unreadEmailNotifications');
Route::get('notifications', [NotificationController::class, '@markAllRead'])->name('readAll');
Route::get('sms', [SmsController::class, 'index'])->name('sms');
Route::post('send-sms', [SmsController::class, 'SendSMS'])->name('sms.store');
Route::get('email', [MailController::class, 'MailWelcome']);


// Pos Routes
Route::get('sales/get-data', [SalesController::class, 'GetSales'])->name('get-sales');
Route::get('sales/fetch/today', [SalesController::class, 'GetTodaySales'])->name('get-daily-sales');
Route::get('sales/today', [SalesController::class, 'salesForToday'])->name('dailysales.index');
Route::get('sales/item/{id}', [SalesController::class, 'GetItem'])->name('getItemName');
Route::get('sales/debts', [SalesController::class, 'salesWithDebtsIndex'])->name('sales.debts');
Route::get('sales/debts/ajax', [SalesController::class, 'GetSalesWithDebts'])->name('get-sales-with-debts');
Route::get('sales/today/debts/ajax', [SalesController::class, 'GetTodaySalesWithDebts'])->name('get-daily-sales-with-debts');
Route::post('sale/transact', [CartController::class, 'recordSale'])->name('sale.record');
Route::post('sales/remove/selected', [SalesController::class, 'RemoveSelected'])->name('selected-sales.remove');
Route::post('sales/filtered-sales', [SalesController::class, 'filterSales'])->name('filtersales');
Route::post('sales/debts/search', [SalesController::class, 'filterSalesWithDebts'])->name('sales.debts.filter');
Route::put('sales/records/update/', [SalesController::class, 'updateSaleRecord'])->name('sales.records.update');
Route::get('sale/make-receipt', [CartController::class, 'getReceipt']);
Route::post('pos/session/update', [CartController::class, 'updateItemInSession'])->name('session.update');
Route::post('pos/record', [CartController::class, 'MakeSaleGateway'])->name('sale.transact');
Route::post('pos/barcode/getItem', [CartController::class, 'GetCartData'])->name('item.get');
Route::post('pos/search', [CartController::class, 'searchItem'])->name('item.search');
Route::post('pos/searchprice', [CartController::class, 'getItemPrice'])->name('cart.searchprice');
Route::post('pos/clear', [CartController::class, 'ClearCart'])->middleware('password.confirm');
Route::post('pos/handler', [CartController::class, 'PopulateCart'])->name('cart.handle');

// Reports Routes
Route::get('reports/ajax/monthly-sales', [ReportsController::class, 'GetMonthlySalesDT'])->name('monthly-sales.ajax');
Route::get('reports/ajax/low-running-stock/{qty?}', [ReportsController::class, 'GetLowStockDT'])->name('low-stock.ajax');
Route::get('reports/ajax/best-selling-items', [ReportsController::class, 'GetBestSellingItemsDT'])->name('best-selling-items.ajax');
Route::get('reports/ajax/cashiers-performance', [ReportsController::class, 'GetCashiersReportDT'])->name('top-cashiers.ajax');
Route::get('reports/ajax/debtors/suppliers', [ReportsController::class, 'GetSupplierDebtorsDT'])->name('debtors-suppliers.ajax');
Route::get('reports/ajax/top-customers', [ReportsController::class, 'GetTopCustomersDT'])->name('top-customers.ajax');
Route::get('reports/ajax/debtors/customers', [ReportsController::class, 'GetCustomerDebtorsDT'])->name('debtors-customers.ajax');
Route::get('reports/low-running-stock/{qty?}', [ReportsController::class, 'lowRunningStock'])->name('low-stock');
Route::get('reports/monthly-sales', [ReportsController::class, 'MonthlySales'])->name('m-sales');
Route::get('reports/best-selling-items', [ReportsController::class, 'BestSellingItems'])->name('best-selling-items');
Route::get('reports/top-customers', [ReportsController::class, 'topCustomers'])->name('top-customers');
Route::get('reports/cashiers-performance', [ReportsController::class, 'topCashiers'])->name('top-cashiers');
Route::get('reports/debtors/customers', [ReportsController::class, 'debtorsCustomersList'])->name('debtors-customers');
Route::get('reports/debtors/suppliers', [ReportsController::class, 'debtorsSuppliersList'])->name('debtors-suppliers');
Route::get('reports/charts/purchases', [ReportsController::class, 'purchaseReports'])->name('reports.charts.purchases');
Route::get('reports/chartdata', [ReportsController::class, 'getMonthlySalesData'])->name('chartdata');
Route::get('reports/expenses/monthly', [ReportsController::class, 'monthlyExpensesReportIndex'])->name('reports.expenses.monthly');
Route::get('reports/expenses/monthly/ajax', [ReportsController::class, 'getMonthlyExpensesReport'])->name('reports.expenses.monthly.ajax');
Route::get('reports', [ReportsController::class, 'index'])->name('reports');


// Settings Routes
Route::get('settings/profile', [ProfileController::class, 'accountSettings'])->name('account-settings');
Route::get('settings/company', [SettingsController::class, 'showCreateCoForm'])->name('companies.create');
Route::post('settings/company/{id}', [SettingsController::class, 'addUpdateCompany'])->name('companies.register');
Route::get('settings/company-details', [SettingsController::class, 'GetCompanies'])->name('companies.home');



// User Routes
Route::get('users/active', [UserController::class, 'ActiveUsersIndex'])->name('user.account.active');
Route::get('users/locked', [UserController::class, 'LockedUsersIndex'])->name('user.account.locked');
Route::get('users/active/fetch', [UserController::class, 'ActiveUsersAjax'])->name('active_user.ajax.fetch');
Route::get('users/locked/fetch', [UserController::class, 'LockedUsersAjax'])->name('locked_user.ajax.fetch');
Route::get('users/managers', [UserController::class, 'fetchManagers'])->name('managers.home');
Route::get('users/managers/ajax', [UserController::class, 'GetManagers'])->name('managers.index.ajax');
Route::get('users/cashiers', [UserController::class, 'fetchCashiers'])->name('cashiers.home');
Route::get('users/cashiers/ajax', [UserController::class, 'GetCashiers'])->name('cashiers.index.ajax');
Route::get('users/fetch/ajax', [UserController::class, 'GetUsers'])->name('users.index.ajax');
Route::get('users/active/remove', [UserController::class, 'RemoveAllActiveUsers'])->name('active-users.remove')->middleware('password.confirm');
Route::get('users/locked/remove', [UserController::class, 'RemoveAllLockedUsers'])->name('locked-users.remove')->middleware('password.confirm');
Route::get('user/lockunlock/{id}/{status}/{name}', [UserController::class, 'LockUnlockAccount'])->name('user.lockunlock');
Route::post('user/lockunlock/', [UserController::class, 'LockUnlockUserAccount'])->name('account.change');
Route::post('users/remove/selected', [UserController::class, 'RemoveSelected'])->name('selected-users.remove');
Route::post('users/search/role', [UserController::class, 'searchRole'])->name('user.searchrole');

Route::get('customers/with-debts/ajax', [CustomersController::class, 'GetCustomersWithDebts'])->name('customers.with.debts.ajax');
Route::get('customers/debt-payments', [CustomersController::class, 'customerDebtPaymentsIndex'])->name('customers.debts.payments.index');
Route::get('customers/debt-payments/ajax', [CustomersController::class, 'GetCustomerDebtPayments'])->name('customers.debts.payments.ajax');
Route::post('customers/remove/selected', [CustomersController::class, 'RemoveSelected'])->name('selected-customers.remove');
Route::post('suppliers/remove/selected', [SuppliersController::class, 'RemoveSelected'])->name('selected-suppliers.remove');
Route::get('customers/home', [CustomersController::class, 'GetCustomers'])->name('customers.home');
Route::post('customers/import', [CustomersController::class, 'importCustomers'])->name('customers.import');
Route::get('customers/export', [CustomersController::class, 'exportCustomers'])->name('customers.export');
Route::get('customers/with-debts', [CustomersController::class, 'customersWithDebtsIndex'])->name('customers.with.debts');
Route::get('customers/with-debts/{id}', [CustomersController::class, 'showCustomerWithDebt']);
Route::post('customer/debts/update', [CustomersController::class, 'updateCustomerDebts'])->name('customer.debt.update');
Route::post('customers/delete/all', [CustomersController::class, 'deleteAllCustomers'])->name('customers.truncate');
Route::post('suppliers/import', [SuppliersController::class, 'importSuppliers'])->name('suppliers.import');
Route::get('suppliers/export', [SuppliersController::class, 'exportSuppliers'])->name('suppliers.export');
Route::get('suppliers/getSuppliers4DT', [SuppliersController::class, 'GetSuppliersData'])->name('getSuppliers4DT');
Route::get('suppliers/home', [SuppliersController::class, 'GetSuppliers'])->name('suppliers.home');
Route::post('suppliers/delete/all', [SuppliersController::class, 'deleteAllSuppliers'])->name('suppliers.truncate');


// Resource Routes
Route::group(['middleware' => 'restricted'], function () {

	Route::resources([
		'stock' => StockController::class,
		'sales' => SalesController::class,
		'product-categories' => StockCategoryController::class,
		'damaged-stock-items' => DamagesController::class,
		'suppliers' => SuppliersController::class,
		'purchases' => PurchasesController::class,
		'expenses' => ExpensesController::class,
		'profile' => ProfileController::class,
		'mail' => MailController::class,
		'logs' => LogsController::class,
		'calendar' => CalendarController::class,
		'users' => UserController::class,
		'pos' => CartController::class,
		'kitchen-orders' => KitchenOrderController::class,
		'room_types' => RoomTypeController::class,
		'rooms' => RoomController::class,
		'guest_types' => GuestTypeController::class,
		'guests' => GuestController::class,
		'invoice_guests' => InvoiceGuestController::class,
		'reservations' => ReservationController::class,
		'departments' => DepartmentController::class,
		'designations' => DesignationController::class,
		'staff' => StaffMemberController::class,
		'staff-permissions' => StaffPermissionController::class,
		'payments' => PaymentController::class,
		'salary' => SalaryController::class,
		'customers' => CustomersController::class,
		'menu-items' => MenuItemController::class,
		'currencies' => CurrencyController::class,
		'frequent-contacts' => FrequentContactController::class,
		'company' => SettingsController::class,
		'menu-item-categories' => KitchenMenuItemCategoryController::class,
	]);


});