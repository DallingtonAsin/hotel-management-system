<div class="card">
    <div class="card-body bg-white">
        {!! Form::open(['route' => 'reservations.store', 'method' => 'POST']) !!}

        <div class="form-group">
            <input type="hidden" class="form-control bg-white" disabled="true" 
             required name="guest_type" value="Corporate" autocomplete="on">
        </div>

        <div class="form-group">
            <input type="text" class="form-control bg-white" disabled="true" placeholder="Enter guest type" required
                name="name" value="Corporate" autocomplete="on" hidden="true">
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>First Name</span>
                <input type="text" class="form-control first_name" required name="first_name" value=""
                    autocomplete="on">
            </div>
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Last Name</span>
                <input type="text" class="form-control last_name" required name="last_name" value=""
                    autocomplete="on">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Company Name</span>
                <input type="text" class="form-control company_name" name="company_name" value="" required
                    autocomplete="on">
            </div>
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>TIN</span>
                <input type="text" class="form-control tax_number" name="tax_number" value="" required
                    autocomplete="on">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Company Contact</span>
                <input type="text" class="form-control company_contact" name="company_contact" value=""
                    required autocomplete="on">
            </div>
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Company Email</span>
                <input type="text" class="form-control company_email" name="company_email" value="" required
                    autocomplete="on">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Phone Number</span>
                <input type="text" class="form-control phone_number" name="phone_number" value="" required
                    autocomplete="on">
            </div>
            <div class="col-md-6">
                <span class="text-muted">Email</span>
                <input type="text" class="form-control email" name="email" placeholder="Enter email" value=""
                    required autocomplete="on">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted">Passport</span>
                <input type="text" class="form-control passport_number" name="passport_number" value=""
                    required autocomplete="on">
            </div>
            <div class="col-md-6">
                <span class="text-muted">NIN</span>
                <input type="text" class="form-control nin" name="nin" value="" required
                    autocomplete="on">
            </div>
        </div>


        <div class="row form-group">

            <div class="col-md-4">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Room Number</span>
                <select name="room_number" class="form-control room_number" required>
                    <option value="">Select room number</option>
                </select>
            </div>

            <div class="col-md-4">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Arrival Time</span>
                <input type="datetime-local" class="form-control arrival_date" required name="arrival_date"
                    value="{{ now()->format('Y-m-d\TH:i') }}" autocomplete="on">
            </div>

            <div class="col-md-4">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Departure Time</span>
                <input type="datetime-local" class="form-control departure_date" required name="departure_date"
                    value="" autocomplete="on">
            </div>
        </div>

        <div class="form-group">
            <span class="text-muted">Other</span>
            <textarea rows="3" class="form-control other_details" name="other_details"></textarea>
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
