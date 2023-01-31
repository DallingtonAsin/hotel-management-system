<div class="card">
    <div class="card-body ">
        {!! Form::open(['route' => 'reservations.store', 'method' => 'POST']) !!}

        <div class="form-group">
            <strong for="exampleRadios1"><i class="text-danger pr-1">*</i>Guest Type</strong>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="guest_type"
                    {{ old('guest_type') == 'Regular' ? 'checked' : '' }} id="Regular" value="Regular" checked>
                <label class="form-check-label" for="Regular">Regular</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="guest_type" id="Walkin" value="Walkin"
                    {{ old('guest_type') == 'Walkin' ? 'checked' : '' }}>
                <label class="form-check-label" for="Walkin">Walkin</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="guest_type" id="Walkin" value="Walkin"
                    {{ old('guest_type') == 'Walkin' ? 'checked' : '' }}>
                <label class="form-check-label" for="Walkin">Corporate</label>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-lg-6">
                <div class="card border-success">
                    <div class="card-header">
                        <h6 class="card-title">Guest personal information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <span class="text-muted"><span class="text-danger">*</span>First Name</span>
                                <input type="text" class="form-control first_name" name="first_name"
                                    value="{{ old('first_name') }}" autocomplete="on">
                            </div>

                            <div class="col-md-6">
                                <span class="text-muted">Last Name</span>
                                <input type="text" class="form-control last_name" name="last_name"
                                    value="{{ old('last_name') }}" autocomplete="on">
                            </div>
                        </div>

                        <div class="row form-group">
                        <div class="col-md-6">
                            <span class="text-muted">Phone Number</span>
                            <input type="text" class="form-control phone_number" name="phone_number"
                                value="{{ old('phone_number') }}" autocomplete="on">
                        </div>

                        <div class="col-md-6">
                            <span class="text-muted">Email</span>
                            <input type="text" class="form-control email" name="email" placeholder=""
                                value="{{ old('email') }}" autocomplete="on">
                        </div>
                        </div>

                        <div class="form-group">
                            <span class="text-muted">Profession/Job Title</span>
                            <input type="text" class="form-control job_title" name="job_title"
                                value="{{ old('job_title') }}" autocomplete="on">
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="card border-success">
                    <div class="card-header">
                        <h6 class="card-title">Guest company information</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Company Name</span>
                            <select class="form-control company_name " name="company_name">
                                <option value="">Select company name</option>
                            </select>
                        </div>

                        <div class="row form-group">
                        <div class="col-md-6">
                            <span class="text-muted"><span class="text-danger">*</span>Company Contact</span>
                            <input type="text" class="form-control company_contact" name="company_contact"
                                value="{{ old('company_contact') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted"><span class="text-danger">*</span>Company Email</span>
                            <input type="text" class="form-control company_email" name="company_email"
                                value="{{ old('company_email') }}" readonly>
                        </div>
                        </div>

                        <div class="form-group">
                            <span class="text-muted"><span class="text-danger">*</span>Price</span>
                            <input type="text" class="form-control company_price" name="company_price"
                                value="{{ old('company_price') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-lg-12">
                <div class="card border-success">
                    <div class="card-header">
                        <h6 class="card-title">Nationality information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-2">
                                <span class="text-muted">Nationality</span>
                                <select name="nationality" class="form-control">
                                    <option value="citizen">Citizen</option>
                                    <option value="non-citizen">Non-Citizen</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <span class="text-muted">Passport</span>
                                <input type="text" class="form-control passport_number" name="passport_number"
                                    value="{{ old('passport_number') }}" autocomplete="on">
                            </div>

                            <div class="col-md-3">
                                <span class="text-muted">NIN</span>
                                <input type="text" class="form-control nin" name="nin"
                                    value="{{ old('nin') }}" autocomplete="on">
                            </div>

                            <div class="col-md-2">
                                <span class="text-muted">Card Issue Date</span>
                                <input type="date" class="form-control passport_expiry_date"
                                    name="passport_expiry_date" value="{{ old('passport_expiry_date') }}">
                            </div>

                            <div class="col-md-2">
                                <span class="text-muted">Card Expiry Date</span>
                                <input type="date" class="form-control passport_expiry_date"
                                    name="passport_expiry_date" value="{{ old('passport_expiry_date') }}">
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row form-group">
            <div class="col-lg-12">
                <div class="card border-success">
                    <div class="card-header">
                        <h6 class="card-title">Accomodation information</h6>
                    </div>
                    <div class="card-body">

                        <div class="row form-group">
                            <div class="col-md-1">
                                <span class="text-muted"><span class="text-danger">*</span>Room</span>
                                <input type="text" name="room_number" id="room_number"
                                    class="form-control room_number" value="{{ old('room_number') }}">
                            </div>

                            <div class="col-md-2">
                                <span class="text-muted"><span class="text-danger">*</span>Occupancy</span>
                                <select class="form-control occupancy_type" name="occupancy_type">
                                    <option value="" {{ old('occupancy_type') == '' ? 'selected' : '' }}>Select
                                        occupancy
                                    </option>
                                    <option value="single" {{ old('occupancy_type') == 'single' ? 'selected' : '' }}>
                                        Single</option>
                                    <option value="double" {{ old('occupancy_type') == 'double' ? 'selected' : '' }}>
                                        Double</option>
                                </select>
                            </div>


                            <div class="col-md-2">
                                <span class="text-muted"><span class="text-danger">*</span>Arrival Time</span>
                                <input type="datetime-local" class="form-control arrival_date" name="arrival_date"
                                    value="{{ old('arrival_date', now()->format('Y-m-d\TH:i')) }}" autocomplete="on">
                            </div>

                            <div class="col-md-2">
                                <span class="text-muted"><span class="text-danger">*</span>Departure Time</span>
                                <input type="datetime-local" class="form-control departure_date"
                                    name="departure_date" value="{{ old('departure_date') }}" autocomplete="on">
                            </div>

                            <div class="col-md-2">
                                <span class="text-muted">Price </span>
                                <input type="text" name="daily_price" id="daily_price"
                                    class="form-control daily_price text-danger" value="{{ old('daily_price') }}" readonly>
                            </div>
                
                            <div class="col-md-1">
                                <span class="text-muted">Discount</span>
                                <input type="text" name="discount" id="discount" class="form-control discount"
                                    value="{{ old('discount') }}" placeholder="0">
                            </div>
                
                            <div class="col-md-2">
                                <span class="text-muted">Total</span>
                                <input type="text" name="total" id="total" class="form-control text-left text-success"
                                    value="{{ old('total') }}">
                            </div>
                        </div>


        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted mr-2">Purpose of Visit </span>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="purpose_of_visit" id="btnradio1" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio1">Company Work</label>
                  
                    <input type="radio" class="btn-check" name="purpose_of_visit" id="btnradio2" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio2">Own Business</label>
                  
                    <input type="radio" class="btn-check" name="purpose_of_visit" id="btnradio3" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio3">Conference</label>

                    <input type="radio" class="btn-check" name="purpose_of_visit" id="btnradio5" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio2">Tourist</label>
                  
                    <input type="radio" class="btn-check" name="purpose_of_visit" id="btnradio6" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio3">Other</label>
                  </div>
            </div>

            <div class="col-md-6">
                <span class="text-muted mr-2">Mode of Payment </span>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="payment_mode" id="btnradio1" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio1">Cash</label>
                  
                    <input type="radio" class="btn-check" name="payment_mode" id="btnradio2" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio2">Company</label>
                  
                    <input type="radio" class="btn-check" name="payment_mode" id="btnradio3" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio3">MOMO Pay</label>

                    <input type="radio" class="btn-check" name="payment_mode" id="btnradio4" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio1">Airtel Money</label>
                  
                    <input type="radio" class="btn-check" name="payment_mode" id="btnradio5" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="btnradio2">Visa Card</label>
                  </div>
            </div>
        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit"
                class="btn btn-primary rounded-pill btn-sm outline-none rounded-pill border-dark"><i
                    class="fa fa-plus-circle pr-1"></i>Submit Reservation</button>
        </div>

    </div>
</div>
{!! Form::close() !!}
