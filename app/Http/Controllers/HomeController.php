<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Reservation;
use App\User;
use Helper;

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
        if(Auth::check())
        {
            $total_staff = User::count();
            $total_rooms = Room::count();
            $total_bookings = Reservation::count();

        return view('pages.home', ['total_staff' => $total_staff, 'total_bookings' => $total_bookings, 'total_rooms' => $total_rooms]);
        }else{
            return redirect('/');
        }
    }

    public function overview()
    {
        if(Auth::check())
        {
            return view('pages.main.overview');
            }else{
                return redirect('/');
            }
       
    }
    
}
