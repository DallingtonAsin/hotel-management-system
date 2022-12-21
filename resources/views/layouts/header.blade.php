<div class="az-header">
    <div class="container-fluid">

      <div class="az-header-left">
        <a href="" id="azSidebarToggle" class="az-header-menu-icon">
            <i class="fa fa-bars text-dark"></i>
        </a>
      </div>

      <div class="az-header-center">
        <h5 class="nav-label colored-icon-1 text-dark text-uppercase text-bold" >
          @if(isset($companyData))
          {{ $companyData['company_name'] }}
          @else
          {{ config('app.name') }}
          @endif
        </h5>
      </div>
      
      <div class="az-header-center row pr-5">

        <div class="col-md-4">
            <h6 class="text-info"><a href=""><i class="fa fa-receipt pr-1"></i>POS</a></h6>
         </div>

         <div class="col-md-4">
            <h6 class="text-warning"><a href=""><i class="fa fa-shopping-cart pr-1"></i>Orders</a></h6>
         </div>

         <div class="col-md-4">
            <h6 class="text-success"><a href=""><i class="fa fa-balance-scale pr-1"></i>Accounting</a></h6>
         </div>
      </div>

      <div class="dropdown az-profile-menu">
        <a href="" class="text-decoration-none nunito-font username text-cap">
          <span class="mt-5 text-dark">{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}
          <i class="fas fa-angle-down text-dark"></i> </span>
          <i class="dropdown-toggle"></i></a>

        <div class="dropdown-menu">
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