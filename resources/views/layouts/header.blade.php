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

        <div class="col-lg-3">
        <a href="{{ route('pos.index') }}"><img src="{{ asset('vendors/img/pos1.png')}}" class="icon-img-1"/>
            <h6 class="header-caption">POS</h6></a>
         </div>

         <div class="col-lg-3">
         <a href=""><img src="{{ asset('vendors/img/cup-tea.png')}}" class="icon-img"/>
            <h6 class="header-caption mt-1">KOTs</h6></a>
         </div>

         <div class="col-lg-3">
         <a href=""><img src="{{ asset('vendors/img/bed.png')}}" class="icon-img-1"/>
            <h6 class="header-caption">Bookings</h6></a>
         </div>

         <div class="col-lg-3">
         <a href=""><img src="{{ asset('vendors/img/finance3.png')}}" class="icon-img-1 text-warning"/>
            <h6 class="header-caption">Accounting</h6></a>
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