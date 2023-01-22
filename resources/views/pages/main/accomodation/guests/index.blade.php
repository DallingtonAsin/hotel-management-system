@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-2 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Guests</strong>
                <span class="badge badge-info total_departments">
                    @isset($total_guests)
                        {{ number_format($total_guests) }}
                    @endisset
                </span>
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover guests-table" id="guests-table">

                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone No.</th>
                            <th>Co. Name</th>
                            <th>Recorded By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>

    @include('pages.main.accomodation.guests.modals.guest_details')

    <!--Modal Delete guests -->
    <div class="modal fade" id="deleteGuestModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog" aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete guest</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this guest
                                <small class="text-dark text-muted bolded">
                                </small>
                                ?

                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary delete-ok-btn" name="ConfirmBtn">Yes</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end of modal Delete Guests-->


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('guests.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const freqContactAjaxUrl = @json(route('frequent-contacts.ajax.fetch'));
        const cat = 'guests';
        const token = "{{ csrf_token() }}";

    </script>

    <script type="text/javascript">
        $(document).ready(function() {


            //code that displays results of the table index()
            let table = $('#guests-table');
            let title = "List of guests in the system";
            let columns = [1, 2, 3, 4];
            let dataColumns = [{
                    data: 'checkbox',
                    name: 'checkbox'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },
                {
                    data: 'created_by',
                    name: 'created_by'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            Numberize(".debt");
            Numberize(".credit");

            //modal used to edit guests details [each row of the tbl]
            $('body').on('click', '#edit-guest', function(event) {
                let guest_id = $(this).data('id');
                event.preventDefault();
                // alert('edit guest');
                checkPermission(permissions.edit_guests, function(guest) {
                    editGuestDetails(guest_id);
                });
            });

            function editGuestDetails(guest_id) {
                $.get("{{ route('guests.index') }}" + '/' + guest_id + '/edit', function(response) {
                    if (response.success) {
                        let data = response.data;
                        let guest_names = `${data.first_name} ${data.last_name}`;
                        $('#modalHeading').html("Edit details of guest " + guest_names + "");
                        $('.editGuestBtn').text("Edit guest");
                        $('#guestDetailsModal').modal('show');
                        populateGuestDetails(data);
                        DisableTableFields(false);
                        ShowBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }


            //View Modal used to view each row [guests details]
            $('body').on('click', '#view-guest', function(event) {
                let guest_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_guests, function(guest) {
                    viewGuestDetails(guest_id);
                });
            });

            function viewGuestDetails(guest_id) {
                $.get("{{ route('guests.index') }}" + '/' + guest_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        let guest_names = `${data.first_name} ${data.last_name}`;
                        $('#modalHeading').html("Details of guest " + guest_names + "");
                        $('#guestDetailsModal').modal('show');
                        populateGuestDetails(data);
                        DisableTableFields(true);
                        HideBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }

                });
            }

            function populateGuestDetails(data) {
                $('.guest_id').val(data.id);
                $('.first_name').val(data.first_name);
                $('.last_name').val(data.last_name);
                $('.email').val(data.email);
                $('.phone_number').val(data.phone_number);
                $('.company_name').val(data.company_id);
                $('.contact_person').val(data.company_contact);
                $('.company_email').val(data.company_email);
                $('.tin').val(data.tax_number);
                $('.passport_number').val(data.passport_number);
                $('.nin').val(data.nin);
                $('.other_details').val(data.other_details);
            }

            //this pops up confirm delete modal
            $('body').on('click', '#delete-guest', function(e) {
                let guest_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_guests, function(guest) {
                    $.get("{{ route('guests.index') }}" + '/' + guest_id + '', function(response) {
                        if (response.success) {
                            let data = response.data;
                            let guest_names = `${data.first_name} ${data.last_name}`;
                            $("#deleteGuestModal").modal('show');
                            $(".delete-alert-text").html(
                                `Are you sure you want to delete guest ${guest_names}?`);
                            $('.delete-ok-btn').on('click', function() {
                                ListenAndDoDeletion(guest_id);
                            });
                        } else {
                            displayResponse(null, response.error, 'error');
                        }

                    });
                });


            });


            function ListenAndDoDeletion(id) {
                let deleteUrl = '{{ route('guests.destroy', ':id') }}';
                deleteUrl = deleteUrl.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(data) {
                        let resp = data.success;
                        $('.delete-ok-btn').html('Yes');
                        $('#deleteGuestModal').modal("hide");
                        displayResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('#guests-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function DisableTableFields(bool) {

                $('.guest_id').attr('disabled', bool);
                $('.first_name').attr('disabled', bool);
                $('.last_name').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.phone_number').attr('disabled', bool);
                $('.company_name').attr('disabled', bool);
                $('.contact_person').attr('disabled', true);
                $('.company_email').attr('disabled', true);
                $('.tin').attr('disabled', bool);
                $('.nin').attr('disabled', bool);
                $('.passport_number').attr('disabled', bool);
                $('.other_details').attr('disabled', bool);
            }

            function HideBtns() {
                $('.editGuestBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.editGuestBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function ResetTblInfo(response) {
                let totl_number, sum_of_credits, sum_of_debts;
                totl_number = FormatNumber(response.totl_no);
                sum_of_credits = FormatNumber(response.totl_credit);
                sum_of_debts = FormatNumber(response.totl_debt);

                $('.totl_guests').html(totl_number);
                $('.totl_credit').html(sum_of_credits);
                $('.totl_debt').html(sum_of_debts);
            }

            function validateForm() {
                let name = $('.name').val();
                let address = $('.address').val();
                let contact = $('.contact').val();
                let errors = [];
                if (name.length < 1) {
                    let nameErr = "Please enter the name of the guest";
                    errors.push(nameErr);
                }
                if (address.length < 1) {
                    let addressErr = "Please enter the address of the guest";
                    errors.push(addressErr);
                }
                if (contact.length < 1) {
                    let contactErr = "Please enter guest's contact";
                    errors.push(contactErr);
                }
                return errors;
            }

            populateFrequentContacts('.company_name');
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
                            $('.contact_person').val(contact_person);
                        }
                    },
                    error: function(data) {
                        console.log('Error on fetching frequent contact details', data);
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

        });
    </script>
    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
@endsection
