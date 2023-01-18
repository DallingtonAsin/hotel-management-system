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

    <!--Modal Delete guests -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
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
                $.get("{{ route('guests.index') }}" + '/' + guest_id + '/edit', function(data) {
                    $('#modalHeading').html("Edit details of guest " + data.name + "");
                    $('.editGuestBtn').text("Edit guest");
                    $('#editGuestDetailsModal').modal('show');
                    $('.guestId').val(data.id);
                    $('.name').val(data.name);
                    $('.address').val(data.address);
                    $('.contact').val(data.contact);
                    $('.email').val(data.email);
                    $('.debt').val(data.debt);
                    $('.credit').val(data.credit);
                    DisableTableFields(false);
                    ShowBtns();
                });
            }


            //View Modal used to view each row [guests details]
            $('body').on('click', '#view-guest', function(event) {
                let guest_id = $(this).data('id');
                event.preventDefault();
                // alert('view guest');

                checkPermission(permissions.view_guests, function(guest) {
                    viewGuestDetails(guest_id);
                });
            });

            function viewGuestDetails(guest_id) {
                $.get("{{ route('guests.index') }}" + '/' + guest_id + '', function(data) {
                    $('#modalHeading').html("Details of guest " + data.name + "");
                    $('#editGuestDetailsModal').modal('show');
                    $('.guestId').val(data.id);
                    $('.name').val(data.name);
                    $('.address').val(data.address);
                    $('.contact').val(data.contact);
                    $('.email').val(data.email);
                    $('.debt').val(data.debt);
                    $('.credit').val(data.credit);
                    DisableTableFields(true);
                    HideBtns();
                });
            }

            //this pops up confirm delete modal
            $('body').on('click', '#delete-guest', function(e) {
                let guest_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.delete_guests, function(guest) {
                    $("#deleteSuppliersModal").modal('show');
                    $(".delete-alert-text").html("Are you sure you want to delete this guest?");
                    $('.delete-ok-btn').on('click', function() {
                        ListenAndDoDeletion(guest_id);
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
                        $('#deleteSuppliersModal').modal("hide");
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

                $('.guestId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
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
 
        });
    </script>
    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
@endsection
