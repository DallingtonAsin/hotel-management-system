<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Staff;
use App\Services\ReportService;

class HomeController extends Controller
{

    protected $reportService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReportService $reportService)
    {
       $this->reportService = $reportService;
    }

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // if(Auth::check())
        // {
            $total_staff = Staff::count();
            $total_rooms = Room::count();
            $total_bookings = Reservation::count();
            $total_guests = Guest::count();
            $monthly_kitchen_orders = $this->reportService->getMonthlyKitchenOrdersData();
            $completed_kitchen_orders = $this->reportService->getMonthlyKitchenOrdersData('paid');

            $paid_monthly_kitchen_orders = $this->reportService->getMonthlyPiechartKitchenOrdersData('paid');
            // dd($paid_monthly_kitchen_orders);
            $pending_monthly_kitchen_orders = $this->reportService->getMonthlyKitchenOrdersData('pending');
            $cancelled_monthly_kitchen_orders = $this->reportService->getMonthlyKitchenOrdersData('cancelled');

            // dd($monthly_kitchen_orders);


        return view('pages.home', ['total_staff' => $total_staff,
                    'total_bookings' => $total_bookings,
                    'total_rooms' => $total_rooms,
                    'total_guests' => $total_guests
                ])->with(compact('monthly_kitchen_orders', 'paid_monthly_kitchen_orders', 'completed_kitchen_orders',
                                 'pending_monthly_kitchen_orders', 'cancelled_monthly_kitchen_orders'));
        // }else{
        //     return redirect('/');
        // }
    }

    public function overview()
    {
        // if(Auth::check())
        // {
            return view('pages.main.overview');
            // }else{
            //     return redirect('/');
            // }
       
    }
    
}
