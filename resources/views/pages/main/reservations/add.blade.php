@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">

            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><span class="fa fa-check-circle"></span></strong>
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
           @endif

            @if (Session::has('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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
                    @include('pages.main.reservations.forms.regular_guest')
                </div>
                <div class="tab-pane fade" id="walkin-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                    tabindex="0">

                </div>
                <div class="tab-pane fade" id="corporate-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                    tabindex="0">
                    @include('pages.main.reservations.forms.corporate_guest')
                </div>
            </div>



        </div>
    </div>


    <script src="{{ asset('vendors/notify/notify.js') }}"></script>

    <script>
        const roomsAjaxUrl = @json(route('rooms.ajax.fetch'));
        populateRooms();
        onSelectGuestType();

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
        });

        onTypingRoomNumber();

        function onTypingRoomNumber() {
            let search_qry = $('.room_number').val();
            $('.room_number').typeahead({
                source: function(search_qry, result) {
                    $.ajax({
                        url: "{{ route('rooms.ajax.suggest') }}",
                        method: 'post',
                        data: {
                            query: search_qry,
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(`Got data`, data);
                            result($.map(data, function(item) {
                                return item;
                            }));
                        },
                        error: function(data) {
                            console.log(data);
                        },
                    });
                }
            });
        }
    </script>
@endsection
