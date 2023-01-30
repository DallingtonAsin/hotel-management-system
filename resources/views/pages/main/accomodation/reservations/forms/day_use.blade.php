<div class="card">
    <div class="card-body ">
        {!! Form::open(['route' => 'reservations.store', 'method' => 'POST']) !!}

        <div class="form-group">
            <input type="hidden" class="form-control "  
             name="guest_type" value="Day Use" autocomplete="off">
        </div>


        <div class="form-group">
            <input type="text" class="form-control " disabled="true" placeholder="" name="name"
                value="Corporate" autocomplete="on" hidden="true">
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>First Name</span>
                <input type="text" class="form-control first_name" name="first_name" value="{{ old('first_name') }}"
                 autocomplete="on">
            </div>
            <div class="col-md-6">
                <span class="text-muted">Last Name</span>
                <input type="text" class="form-control last_name" name="last_name" value="{{ old('last_name') }}" autocomplete="on">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-12">
                <span class="text-muted">Phone Number</span>
                <input type="text" class="form-control phone_number" name="phone_number" value="{{ old('phone_number') }}"
                    autocomplete="on">
            </div>
        </div>

        <div class="row form-group">

            <div class="col-md-3">
                <span class="text-muted">Email</span>
                <input type="text" class="form-control email" name="email" placeholder="" value="{{ old('email') }}"
                    autocomplete="on">
            </div>

            <div class="col-md-3">
                <span class="text-muted">Passport</span>
                <input type="text" class="form-control passport_number" name="passport_number" value="{{ old('passport_number') }}"
                    autocomplete="on">
            </div>
            <div class="col-md-3">
                <span class="text-muted">Passport Expiry Date</span>
                <input type="date" class="form-control passport_expiry_date" name="passport_expiry_date" value="{{ old('passport_expiry_date') }}">
            </div>
            <div class="col-md-3">
                <span class="text-muted">NIN</span>
                <input type="text" class="form-control nin" name="nin" value="{{ old('nin') }}" autocomplete="on">
            </div>
        </div>


        <div class="row form-group">

            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Room Number</span>
                <input type="text" name="room_number" id="room_number" class="form-control room_number" value="{{ old('room_number') }}">
            </div>

            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Occupancy</span>
                <select class="form-control occupancy_type" name="occupancy_type">
                <option value="" {{ old('occupancy_type') == '' ? 'selected' : '' }}>Select occupancy</option>
                <option value="single" {{ old('occupancy_type') == 'single' ? 'selected' : '' }}>Single</option>
                <option value="double" {{ old('occupancy_type') == 'double' ? 'selected' : '' }}>Double</option>
                </select>
            </div>

          
            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Arrival Time</span>
                <input type="datetime-local" class="form-control arrival_date" name="arrival_date"
                    value="{{ old('arrival_date', now()->format('Y-m-d\TH:i')) }}" autocomplete="on">
            </div>

            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Departure Time</span>
                <input type="datetime-local" class="form-control departure_date" 
                name="departure_date" value="{{ old('departure_date') }}" autocomplete="on">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-4">
                <span class="text-muted">Daily Price </span>
                <input type="text" name="daily_price" id="daily_price" class="form-control daily_price text-danger"
                    value="{{ old('daily_price') }}" readonly>
            </div>

            <div class="col-md-4">
                <span class="text-muted">Discount / Per Day</span>
                <input type="text" name="discount" id="discount" class="form-control discount"
                    value="{{ old('discount') }}" placeholder="0">
            </div>

            <div class="col-md-4">
                <span class="text-muted">Total</span>
                <input type="text" name="total" id="total" class="form-control text-left text-success"
                    value="{{ old('total') }}">
            </div>
        </div>

        <div class="form-group">
            <span class="text-muted">Other</span>
            <textarea rows="3" class="form-control other_details" name="other_details"></textarea>
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary rounded-pill btn-sm outline-none rounded-pill border-dark"><i
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
