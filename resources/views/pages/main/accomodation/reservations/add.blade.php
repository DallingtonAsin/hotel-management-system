@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">

            @include('pages.main.messages.response')

            <ul class="nav nav-tabs guest-types-tab" id="GuestTypesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#regular-tab-pane"
                        type="button" role="tab" aria-controls="regular-tab-pane" aria-selected="true"><small>Regular |
                            Walkin Guest</small></button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#corporate-tab-pane"
                        type="button" role="tab" aria-controls="corporate-tab-pane"
                        aria-selected="false"><small>Corporate Guest</small></button>
                </li>

            </ul>
            <div class="tab-content mt-3 px-2" id="GuestTypesTabContent">
                <div class="tab-pane fade show active" id="regular-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                    tabindex="0">
                    @include('pages.main.accomodation.reservations.forms.regular_guest')
                </div>
                <div class="tab-pane fade" id="walkin-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                    tabindex="0">

                </div>
                <div class="tab-pane fade" id="corporate-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
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
@endsection
