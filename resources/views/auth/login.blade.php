
@extends('layouts.app')

@section('content')

<div class="container">
<div class="row justify-content-center">
  <div class="col-md-3 login mt-5">

    <div class="card">
   <div class="card-body">
    <form method="POST" action="{{ route('authenticate') }}">
      @csrf

       <div class="header nunito-font">
      <div class="row justify-content-center ">
        @if(isset($companyData) && isset($companyData['company_logo']))
        <img src="{{ asset('uploads/images/company/logo/'.$companyData['company_logo'].'') }}" class="co-icon-center" alt="">
        @else
        <img src="{{ asset('uploads/images/company/logo/default/brand.jpg') }}" class="co-icon-center">
        @endif
      </div>


      <div class="row justify-content-center">
    <label class="col-form-label text-dark font-weight-bold text-md-center">
      @if(isset($companyData))
     {{ $companyData['company_name'] }}
     @else
     {{ env('APP_NAME') }}
     @endif
   </label>
      </div>
  </div>

      <div class="form-group text-center">
                                <h6 class="text-dark nunito-font ">Sign in to start your session</h6>
                                </div>
      <div class="form-group">
        <span class="login_span bolded nunito-font">Username or email</span>
        <input id="pos_login" type="text"
        class="form-control nunito-font
        @error('pos_login') is-invalid @enderror
        " name="pos_login" value="{{old('pos_login')}}"
        placeholder="Enter your email or username"  required autocomplete="email" autofocus spellcheck="false">
      </div>

      <div class="form-group ">
        <div class="row">
        <div class="col-md-6">
        <span class="login_span nunito-font bolded">Password</span>
        </div>
        </div>

        <input id="password" type="password" class="password form-control  @error('pos_password') is-invalid @enderror nunito-font" name="pos_password" placeholder="Enter your password"
        value="" autocomplete="off" required>
          <small class="text-decoration-none text-info showPwd">
          </small>

        @error('password')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-sm btn-block text-white btn-primary bolded">
          <strong>{{ __('Sign in') }}</strong>
        </button>
      </div>

      <div class="form-group px-0 py-0">
        @if($errors->any())
        <span class="login-error nunito-font">
          <span>{{$errors->first()}}</span>
        </span>
        @endif

     
       <strong class="ml-3">
        <h6 class="text-center">
        {{ __('Need a hotel quickbook?') }}
        <a href="https://pivosoftltd.com" target="_blank" class="pr-3 text-info"> Contact us</a>
        </h6>
      </strong>
     </div>
</form>
</div>
    </div>
</div>
</div>
</div>
</div>

<script src="{{ asset('vendors/js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/login/login.js') }}"></script>
<script>
     @if(session()->get('loginErr'))
        toastr.error("{{session()->get('loginErr')}}");
     @endif

       @if(session()->get('sessionExpiredMessage'))
         toastr.error("{{session()->get('sessionExpiredMessage')}}");
       @endif
</script>

@endsection
