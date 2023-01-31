<div class="card">
    <div class="card-body ">
        {!! Form::open(['route' => 'reservations.store', 'method' => 'POST']) !!}

        <div class="form-group">
            <strong for="exampleRadios1"><i class="text-danger pr-1">*</i>Guest Type</strong>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="guest_type" id="Day Use" value="Day Use" checked
                    {{ old('guest_type') == 'Day Use' ? 'checked' : '' }}>
                <label class="form-check-label" for="Day Use">Day Use</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="guest_type"
                    {{ old('guest_type') == 'Regular' ? 'checked' : '' }} id="Regular" value="Regular">
                <label class="form-check-label" for="Regular">Regular</label>
            </div>
         

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="guest_type" id="Corporate" value="Corporate"
                    {{ old('guest_type') == 'Corporate' ? 'checked' : '' }}>
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
                                <span class="text-muted"><span class="text-danger pr-1">*</span>Phone Number</span>
                                <input type="text" class="form-control phone_number" name="phone_number"
                                    value="{{ old('phone_number') }}" autocomplete="on">
                            </div>

                            <div class="col-md-6">
                                <span class="text-muted">Email</span>
                                <input type="text" class="form-control email" name="email" placeholder=""
                                    value="{{ old('email') }}" autocomplete="on">
                            </div>
                        </div>

                        <div class="row form-group">
                        <div class="col-md-6">
                            <span class="text-muted">Profession/Job Title</span>
                            <input type="text" class="form-control job_title" name="job_title"
                                value="{{ old('job_title') }}" autocomplete="on">
                        </div>

                        <div class="col-md-6">
                            <span class="text-muted">Guest Tin Number</span>
                            <input type="text" class="form-control guest_tin" name="guest_tin"
                                value="{{ old('guest_tin') }}" autocomplete="on">
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 general_company_info">
                <div class="card border-success">
                    <div class="card-header">
                        <h6 class="card-title">{{ $company->name }}</h6>
                    </div>
                    <div class="card-body">
                      <p>Street: {{$company->street}}</p>
                      <p>City: {{$company->city}}</p>
                      <p>State: {{$company->state}}</p>
                      <p>Tel: {{$company->phone_number}}</p>
                      <p>Email: {{$company->email}}</p>
                      <p>Website: {{$company->website_url}}</p>
                    </div>
                </div>
            </div>


            <div class="col-lg-6 company_info_section">
                <div class="card border-success">
                    <div class="card-header">
                        <h6 class="card-title">Guest company information</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Company Name</span>
                            <select class="form-control company_name " name="company_name" value="{{ old('company_name') }}">
                                <option value="">Select company name</option>
                                @foreach ($frequent_contacts as $contact)
                                   <option value="{{ $contact->id }}" {{ old('company_name') == $contact->id ? 'selected' : '' }} >{{ $contact->name }}</option>
                                @endforeach
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

                        <div class="row form-group">
                            <div class="col-md-12">
                                <span class="text-muted"><span class="text-danger">*</span>Company TIN</span>
                                <input type="text" class="form-control company_tin" name="company_tin"
                                    value="{{ old('company_tin') }}" readonly>
                            </div>

                            {{-- <div class="col-md-6">
                                <span class="text-muted"><span class="text-danger">*</span>Price</span>
                                <input type="text" class="form-control company_price" name="company_price"
                                    value="{{ old('company_price') }}" readonly>
                            </div> --}}
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
                                <span class="text-muted"><span class="text-muted"><span
                                            class="text-danger">*</span>Nationality</span>
                                    <input type="text" name="nationality" value="Ugandan" class="form-control nationality" placeholder="Enter nationality"/>
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
                                <input type="date" class="form-control card_issue_date" name="card_issue_date"
                                    value="{{ old('card_issue_date') }}">
                            </div>

                            <div class="col-md-2">
                                <span class="text-muted">Card Expiry Date</span>
                                <input type="date" class="form-control card_expiry_date" name="card_expiry_date"
                                    value="{{ old('card_expiry_date') }}">
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
                                    class="form-control daily_price text-danger" value="{{ old('daily_price') }}"
                                    readonly>
                            </div>

                            <div class="col-md-1">
                                <span class="text-muted">Discount</span>
                                <input type="text" name="discount" id="discount" class="form-control discount"
                                    value="{{ old('discount', 0) }}">
                            </div>

                            <div class="col-md-2">
                                <span class="text-muted">Total</span>
                                <input type="text" name="total" id="total"
                                    class="form-control text-left text-success" value="{{ old('total') }}">
                            </div>
                        </div>


                        <div class="row form-group">
                            <div class="col-md-6">
                                <span class="text-muted mr-2"><span class="text-danger pr-1">*</span>Purpose of Visit </span>
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="purpose_of_visit" value="Company Work" id="purpose_1" {{ old('purpose_of_visit') == 'Company Work' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="purpose_1">Company Work</label>

                                    <input type="radio" class="btn-check" name="purpose_of_visit" value="Own Business" id="purpose_2" {{ old('purpose_of_visit') == 'Own Business' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="purpose_2">Own Business</label>

                                    <input type="radio" class="btn-check" name="purpose_of_visit" value="Conference" id="purpose_3" {{ old('purpose_of_visit') == 'Conference' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="purpose_3">Conference</label>

                                    <input type="radio" class="btn-check" name="purpose_of_visit" value="Tourist" id="purpose_4" {{ old('purpose_of_visit') == 'Tourist' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="purpose_4">Tourist</label>

                                    <input type="radio" class="btn-check" name="purpose_of_visit" value="Other" id="purpose_5" {{ old('purpose_of_visit') == 'Other' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="purpose_5">Other</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <span class="text-muted mr-2"><span class="text-danger pr-1">*</span>Mode of Payment </span>
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="payment_mode" value="Cash" id="mode_1" {{ old('payment_mode') == 'Cash' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="mode_1">Cash</label>

                                    <input type="radio" class="btn-check" name="payment_mode" value="Company" id="mode_2" {{ old('payment_mode') == 'Company' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="mode_2">Company</label>

                                    <input type="radio" class="btn-check" name="payment_mode" value="MOMO Pay" id="mode_3" {{ old('payment_mode') == 'MOMO Pay' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="mode_3">MOMO Pay</label>

                                    <input type="radio" class="btn-check" name="payment_mode" value="Airtel Money" id="mode_4" {{ old('payment_mode') == 'Airtel Money' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="mode_4">Airtel Money</label>

                                    <input type="radio" class="btn-check" name="payment_mode" value="Visa Card" id="mode_5" {{ old('payment_mode') == 'Visa Card' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="mode_5">Visa Card</label>
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
