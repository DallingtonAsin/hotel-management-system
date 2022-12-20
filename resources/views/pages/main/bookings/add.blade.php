@extends('layouts.template')

@section('content')

      <div class="card card-primary">
        <div class="card-header bg-secondary">
          <span class="card-title text-white">Reserve Accomodation</span>
        </div>

      <div class="card-body">

        <form class="form" method="post" action="{{ route('companies.register', isset($company)?$company['id']:0) }}"
          enctype='multipart/form-data'>
          @csrf

          <div class="form-group">
            <span class="text-muted"><span class="text-danger pr-2">*</span>Name</span>
            <input type="text" class="form-control" placeholder="Enter client first name" required name="name"
              value="" autocomplete="off">
          </div>

          <div class="form-group">
            <span class="text-muted"><span class="text-danger pr-2">*</span>Phone Number</span>
            <input type="text" class="form-control" name="phone_number" placeholder="Enter phone number"
              value="" required autocomplete="off">
          </div>

          <div class="form-group">
            <span class="text-muted">Email</span>
            <input type="text" class="form-control" name="email" placeholder="Enter email"
              value="" required autocomplete="off">
          </div>

          <div class="form-group">
            <span class="text-muted"><span class="text-danger pr-2">*</span>Passport</span>
            <input type="text" class="form-control" name="passport_id" placeholder="Enter company email"
              value="" required autocomplete="off">
          </div>

          <div class="form-group">
            <span class="text-muted"><span class="text-danger pr-2">*</span>NIN</span>
            <input type="text" class="form-control" name="nin" placeholder="Enter company email"
              value="" required autocomplete="off">
          </div>


          <div class="form-group">
            <span class="text-muted"><span class="text-danger pr-2">*</span>Room Number</span>
            <input type="text" class="form-control" placeholder="Enter room number" required name="company_address"
              value="" autocomplete="off">
          </div>

          <div class="form-group">
            <span class="text-muted"><span class="text-danger pr-2">*</span>Guest Type</span>
            <select name="guest_type" class="form-control" required>
              <option value="">Select guest type</option>
              @foreach($guest_types as $type)
                   <option value="{{$type->name}}">{{$type->name}}</option>
              @endforeach
           </select>
          </div>


          <div class="form-group">
            <span class="text-muted"><span class="text-danger pr-2">*</span>Arrival Time</span>
            <input type="datetime-local" class="form-control" placeholder="Enter arrival time" required name="company_address"
              value="" autocomplete="off">
          </div>

          <div class="form-group">
            <span class="text-muted"><span class="text-danger pr-2">*</span>Departure Time</span>
            <input type="datetime-local" class="form-control" placeholder="Enter departure time" required name="company_address"
              value="" autocomplete="off">
          </div>

  
          <div class="form-group">
            <input type="submit" class="btn btn-sm btn-primary border-dark"
              value="<?= isset($company)? 'Update' : 'Add Company'?>">
          </div>

          <div class="row form-group">
            <div class="col-lg-9">
              <span class="pl-0 response"></span>
            </div>
          </div>

        </form>
      </div>
    </div>


<script src="{{ asset('vendors/notify/notify.js') }}"></script>

@if(session()->get('success'))
<script>
  $(document).ready(function () {
    var div = ".response";
    var type = "success";
    var LoginMessageError = "{{ session()->get('success') }}";
    ShowLoginErrorMessage(div, type, LoginMessageError);
  });

</script>
@endif

@endsection