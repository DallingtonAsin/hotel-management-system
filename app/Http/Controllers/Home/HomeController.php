<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Staff;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
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


        return view('pages.home', ['total_staff' => $total_staff,
                    'total_bookings' => $total_bookings,
                    'total_rooms' => $total_rooms,
                    'total_guests' => $total_guests
                ]);
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
