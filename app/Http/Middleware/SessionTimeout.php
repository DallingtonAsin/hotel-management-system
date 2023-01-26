<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Models\Staff;

class SessionTimeout
{

  protected $session;
      protected $timeout = 1800; // 30 minutes

      public function __construct(Store $session)
      {
        $this->session = $session;
      }
      /**
       * Handle an incoming request.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  \Closure  $next
       * @return mixed
       */
      public function handle($request, Closure $next)
      {
        $isLoggedIn = $request->path() != '/logout';
        $lastActivityTime = $this->session->get('lastActivityTime');
        (($this->timeout/60) > 1)
           ? $units = "minutes"
           : $units = "minute";

        if(! session('lastActivityTime'))
        {
          $this->session->put('lastActivityTime', time());
        }

        else if(time() - $lastActivityTime  > $this->timeout)
        {
          $this->session->forget('lastActivityTime');
          $cookie = cookie('intend', $isLoggedIn ? url()->current() : 'dashboard');
          $email = $request->user()->email;
          Staff::where("id", $request->user()->id)
               ->update(["otp_code" => null, "is_verified" => false]);

        $msg = "session timed out after ".$this->timeout/60 ." ".$units." inactive";
        $dataArr = array("code" => '404',
        "message" => $msg,
        "method" => "Middleware@SessionTimeout@handle"
        );
        Helper::LogRequest($request, $dataArr); 
        Helper::logger($request, $msg, now());


          Auth::logout();
          //Session::flush();
          if ($request->session()->exists('pos_login')) {
            $request->session()->forget('pos_login');
          }
          if ($request->session()->exists('pos_password')) {
            $request->session()->forget('pos_password');
          }  
         // $this->session->flush();

          
          $message = "No activity within ".$this->timeout/60 ." ".$units."";
          return redirect()->route('login')->with('sessionExpiredMessage',$message);
        }


        $isLoggedIn 
        ? $this->session->put('lastActivityTime', time())
        : $this->session->forget('lastActivityTime');

        return $next($request);
      }


    }
