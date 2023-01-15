<div class="card">
    <div class="card-body bg-white">
        {!! Form::open(['route' => 'reservations.store', 'method' => 'POST']) !!}

        <div class="form-group">
            <input type="hidden" class="form-control bg-white"  
             name="guest_type" value="Corporate" autocomplete="off">
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>First Name</span>
                <input type="text" class="form-control first_name" name="first_name" value="{{ old('first_name') }}"
                    >
            </div>
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Last Name</span>
                <input type="text" class="form-control last_name" name="last_name" value="{{ old('last_name') }}"
                    >
            </div>
        </div>

        <div class="row form-group">
         
            <div class="col-md-6">
                <span><span class="text-danger pr-1">*</span>Company Name</span>
                <select class="form-control company_name bg-white" name="company_name">
                    <option value="">Select company name</option>
                </select>
            </div>

            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>TIN</span>
                <input type="text" class="form-control tax_number" name="tax_number" value="{{ old('tax_number') }}" readonly>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Company Contact</span>
                <input type="text" class="form-control company_contact" name="company_contact" value="{{ old('company_contact') }}" readonly>
            </div>
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Company Email</span>
                <input type="text" class="form-control company_email" name="company_email" value="{{ old('company_email') }}" readonly>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Phone Number</span>
                <input type="text" class="form-control phone_number" name="phone_number" value="{{ old('phone_number') }}"
                    >
            </div>
            <div class="col-md-3">
                <span class="text-muted">Email</span>
                <input type="text" class="form-control email" name="email" placeholder="Enter email" value="{{ old('email') }}"
                    >
            </div>

            <div class="col-md-3">
                <span class="text-muted">Passport</span>
                <input type="text" class="form-control passport_number" name="passport_number" value="{{ old('passport_number') }}"
                    >
            </div>
            <div class="col-md-3">
                <span class="text-muted">NIN</span>
                <input type="text" class="form-control nin" name="nin" value="{{ old('nin') }}">
            </div>

        </div>

   

        <div class="row form-group">

            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Occupancy</span>
                <select class="form-control occupancy_type" name="occupancy_type">
                <option value="" {{ old('occupancy_type') == '' ? 'selected' : '' }}>Select occupancy</option>
                <option value="single" {{ old('occupancy_type') == 'single' ? 'selected' : '' }}>Single</option>
                <option value="double" {{ old('occupancy_type') == 'double' ? 'selected' : '' }}>Double</option>
                </select>
            </div>

            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Room Number</span>
                <input type="text" name="room_number" id="room_number" class="form-control room_number" value="{{ old('room_number') }}">
            </div>

            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Arrival Time</span>
                <input type="datetime-local" class="form-control arrival_date" name="arrival_date"
                    value="{{ old('arrival_date', now()->format('Y-m-d\TH:i')) }}" >
            </div>

            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Departure Time</span>
                <input type="datetime-local" class="form-control departure_date" name="departure_date"
                    value="{{ old('departure_date') }}" >
            </div>
        </div>

        <div class="form-group">
            <span class="text-muted">Other</span>
            <textarea rows="3" class="form-control other_details" name="other_details" value="{{ old('other_details') }}"></textarea>
        </div>


        <div class="form-group mt-4">
            <button type="submit" class="btn btn-sm btn-primary border-dark"><i
                    class="fa fa-plus-circle pr-1"></i>Submit Reservation</button>
        </div>

        <div class="row form-group">
            <div class="col-lg-9">
                <span class="pl-0 response"></span>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
