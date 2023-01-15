<div class="card">
    <div class="card-body bg-white">
        {!! Form::open(['route' => 'reservations.store', 'method' => 'POST']) !!}

        <div class="form-group">
            <label for="exampleRadios1"><i class="text-danger pr-1">*</i>Guest Type</label>
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
        </div>


        <div class="form-group">
            <input type="text" class="form-control bg-white" disabled="true" placeholder="" name="name"
                value="Corporate" autocomplete="on" hidden="true">
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>First Name</span>
                <input type="text" class="form-control first_name" name="first_name" value="{{ old('first_name') }}"
                    autocomplete="on">
            </div>
            <div class="col-md-6">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Last Name</span>
                <input type="text" class="form-control last_name" name="last_name" value="{{ old('last_name') }}"
                    autocomplete="on">
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

        <div class="row form-group">
            <div class="col-md-6">
                <span class="text-muted">Passport</span>
                <input type="text" class="form-control passport_number" name="passport_number"
                    value="{{ old('passport_number') }}" autocomplete="on">
            </div>
            <div class="col-md-6">
                <span class="text-muted">NIN</span>
                <input type="text" class="form-control nin" name="nin" value="{{ old('nin') }}"
                    autocomplete="on">
            </div>
        </div>


        <div class="row form-group">

            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Room Number</span>
                <input type="text" name="room_number" id="room_number" class="form-control room_number"
                    value="{{ old('room_number') }}">
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
                <input type="datetime-local" class="form-control arrival_date" name="arrival_date" id="arrival_date"
                    value="{{ old('arrival_date', now()->format('Y-m-d\TH:i')) }}" autocomplete="on">
            </div>

            <div class="col-md-3">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Departure Time</span>
                <input type="datetime-local" class="form-control departure_date" name="departure_date"
                    id="departure_date" value="{{ old('departure_date') }}" autocomplete="on">
            </div>



        </div>

        <div class="row form-group">

            <div class="col-md-4">
                <span class="text-muted"><span class="text-danger pr-2">*</span>Daily Price </span>
                <input type="text" name="daily_price" id="daily_price" class="form-control daily_price text-danger"
                    value="{{ old('daily_price') }}">
            </div>

            <div class="col-md-4">
                <span class="text-muted">Discount</span>
                <input type="text" name="discount" id="discount" class="form-control discount"
                    value="{{ old('discount') }}" placeholder="Default is 0">
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

<script>

    Numberize('#discount');

    $('.occupancy_type').on('change', function() {
        let occupancy_type = $(this).find(":selected").val();
        if (occupancy_type) {
            let room_number = $('#room_number').val();
            if (room_number) {
                populateRoomPrice(room_number, occupancy_type);
            } else {
                alert("Enter room number first before select occupancy to see the price");
            }
        } else {
            alert("Empty value");
        }
    });

    function populateRoomPrice(number, type) {
        let url = "{{ route('room.price.ajax.fetch') }}"
        $.ajax({
            type: "POST",
            url: url,
            data: {
                room_number: number,
                occupancy_type: type
            },
            dataType: "json",
            success: function(resp) {

                let message = resp.success || resp.error;
                if (resp.success) {
                    let price = resp.data;
                    $('.daily_price').val(price);
                } else {
                    alert(message);
                }
            },
            error: function(data) {
                console.log('Error on fetching price for the room', data);
                console.log('Error:', data.error);
                displayResponse('.response', data.error, 'error');
            }
        });
    }

    function ComputeTotal() {

        let price = $('.daily_price').val();
        let arrival_date = $('.arrival_date').val();
        let departure_date = $('.departure_date').val();

        if (arrival_date && departure_date) {
            let days = getNumberOfDays(arrival_date, departure_date);
            if (price) {
                price = Convert2Num(price);
                let discount = $('#discount').val();
                discount = discount ? parseFloat(Convert2Num(discount)) : 0;
                let total = (price * days) - discount;
                $('#total').val(total.toLocaleString());

            } else {
                alert("No room price");
            }
        } else {
            alert("No dates captured");
        }
    }

    $(".arrival_date").on('change', function() {
        ComputeTotal();
    });

    $(".departure_date").on('change', function() {
        ComputeTotal();
    });

    $("#discount").on('input', function() {
        ComputeTotal();
    });


    function getNumberOfDays(start_date, end_date) {
        let date1 = new Date(start_date);
        let date2 = new Date(end_date);
        let diffInMilliseconds = Math.round(Math.abs(date2 - date1));
        let diffInDays = parseInt(diffInMilliseconds / 86400000);
        return diffInDays;
    }
</script>
