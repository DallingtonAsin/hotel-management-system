@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">

            @include('pages.main.messages.response')

            <ul class="nav nav-tabs guest-types-tab" id="GuestTypesTab" role="tablist">

                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#day-use-tab-pane"
                        type="button" role="tab" aria-controls="day-use-tab-pane" aria-selected="false"><small>Day Use Guest</small></button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#regular-tab-pane"
                        type="button" role="tab" aria-controls="regular-tab-pane" aria-selected="true"><small>Regular | Walkin Guest</small></button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#corporate-tab-pane"
                        type="button" role="tab" aria-controls="corporate-tab-pane" aria-selected="false"><small>Corporate Guest</small></button>
                </li>

            </ul>
            <div class="tab-content mt-3 px-2" id="GuestTypesTabContent">
               
                <div class="tab-pane fade show active" id="day-use-tab-pane" role="tabpanel" aria-labelledby="day-use-tab" tabindex="0">
                    @include('pages.main.accomodation.reservations.forms.day_use')
                </div>

                <div class="tab-pane fade" id="regular-tab-pane" role="tabpanel" aria-labelledby="regular-tab"  tabindex="0">
                    @include('pages.main.accomodation.reservations.forms.regular_guest')
                </div>

                <div class="tab-pane fade" id="corporate-tab-pane" role="tabpanel" aria-labelledby="corporate-tab"
                    tabindex="0">
                    @include('pages.main.accomodation.reservations.forms.corporate_guest')
                </div>
            </div>



        </div>
    </div>


    <script src="{{ asset('vendors/notify/notify.js') }}"></script>

    <script>
        const roomsAjaxUrl = @json(route('rooms.ajax.fetch'));
        const searchRoomUrl = @json(route('rooms.ajax.suggest'));
        const freqContactAjaxUrl = @json(route('frequent-contacts.ajax.fetch'));

        populateRooms();
        onSelectGuestType();
        populateFrequentContacts('.company_name');

        function onSelectGuestType() {
            $('.guest_types_section').on('change', function() {
                let guest_type_id = $(this).find(":selected").val();
                alert('guest_type_id' + guest_type_id);
                if (guest_type_id) {
                    populateDesignations(guest_type_id);
                }
            });
        }

    </script>

    @if (session()->get('success'))
        <script>
            $(document).ready(function() {
                var div = ".response";
                var type = "success";
                var LoginMessageError = "{{ session()->get('success') }}";
                ShowLoginErrorMessage(div, type, LoginMessageError);
            });
        </script>
    @endif

    <script type="text/javascript">
        var $ = jQuery;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            onSelectFreqContactName();

            function onSelectFreqContactName() {
                $('.company_name').on('change', function() {
                    let freq_contact_id = $(this).find(":selected").val();
                    if (freq_contact_id) {
                        populateFreqContactDetails(freq_contact_id);
                    }
                });
            }

            function populateFreqContactDetails(id) {

                let url = '{{ route('frequent-contact-details.ajax.fetch', ':freq_contact_id') }}';
                url = url.replace(':freq_contact_id', id);

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(resp) {

                        let obj = JSON.parse(resp);
                        for (let i = 0; i < obj.length; i++) {
                         
                            let email = obj[i]['email'];
                            let phone_number = obj[i]['phone_number'];
                            let tin = obj[i]['tin'];
                            let contact_person = obj[i]['contact_person'];
                            let price = obj[i]['price'];

                            $('.company_email').val(email);
                            $('.company_contact').val(phone_number);
                            $('.tax_number').val(tin);
                            $('.contact_person').val(contact_person);
                            $('.price').val(price);

                        }
                    },
                    error: function(data) {
                        console.log('Error on fetching designations', data);
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }


        });

        onTypingRoomNumber('.room_number');

      

        let urlParams = new URLSearchParams(window.location.search);
        let tab = urlParams.get('tab');
        if (tab) {
            $('#tabs a[href="#' + tab + '"]').tab('show');
        }
    </script>

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
@endsection
