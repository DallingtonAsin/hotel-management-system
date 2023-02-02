@extends('layouts.master')

@section('content')
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h6 class="text-left text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Reservations</strong>
                <span class="badge badge-info total_departments">
                    @isset($total_reservations)
                        {{ number_format($total_reservations) }}
                    @endisset
                </span>
            </h6>


            <div class="btn-group float-right justify-content-between mb-2">
                <a href="{{ route('reservations.create') }}"
                    class="btn btn-primary btn-sm mx-2 rounded-pill outline-none ml-auto mb-2 text-white"
                    id="addNewDesignation">
                    <i class="fa fa-plus-circle pr-1"></i>Add reservation</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive-lg">

                <table class="table table-bordered table-hover reservations-table" id="reservations-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Guest name</th>
                            <th>Guest Type</th>
                            <th>Arr. date</th>
                            <th>Dept. date</th>
                            <th>Days</th>
                            <th>Room</th>
                            <th>Invoice No.</th>
                            <th>Invoice Status</th>
                            <th>Amt</th>
                            <th>Tax</th>
                            <th>Total Amt</th>
                            {{-- <th>Recorded By</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>

    <!--Add rooms -->
    <div class="modal fade nunito-font addSuppliersModal" id="addSuppliersModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="reservations" id="SuppliersForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new reservation</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> --}}
                            <input type="hidden" class="form-control reservationId  reservationId" name="id"
                                placeholder="Enter reservation id" Required autofocus>
                        </div>

                        <div class="form-group">
                            <span>Name</span>
                            <input type="text" class="form-control name " name="name"
                                placeholder="Enter reservation name" Required autofocus>
                        </div>

                        <div class="form-group">
                            <span>Address</span>
                            <input type="text" class="form-control address " name="address" placeholder="Enter address"
                                Required autofocus>
                        </div>


                        <div class="form-group">
                            <span>Contact</span>
                            <input type="text" class="form-control contact " name="contact" placeholder="Enter contact"
                                Required autofocus>
                        </div>


                        <div class="form-group">
                            <span>Email</span>
                            <input type="email" class="form-control email " name="email" placeholder="Email (optional)">
                        </div>


                        <div class="form-group">
                            <span>Debt</span>
                            <input type="text" class="form-control debt " name="debt" placeholder="Enter debt">
                        </div>


                        <div class="form-group">
                            <span>Credit</span>
                            <input type="text" class="form-control credit " name="credit" placeholder="Enter credit">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary rounded-pill addReservationBtn"
                                name="addReservationBtn">Save</button>
                            <button type="reset" class="btn btn-danger rounded-pill clearBtn">Clear</button>
                            <button type="button" class="btn btn-dark closeBtn" data-bs-dismiss="modal">Close</button>
                        </div>

                        <div class="form-group">
                            <span class="errors-section text-danger nunito-font"></span>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

  
    <!--Modal Status Reservation -->
    <div class="modal fade" id="changeReservationStatus" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold text-center">
                        Change Reservation Status</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label><span class="text-danger pr-1">*</span> Reservation status</label>
                        <select name="status" class="form-control reservation_status" id="reservation_status">
                            <option value="">Select reservation status</option>
                            @foreach (config('reservation-statuses') as $status)
                                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group paid-option-fields">
                        <label><span class="text-danger pr-1">*</span> Payment method</label>
                        <select name="payment_method" class="form-control payment_method">
                            <option value="">Select payment method</option>
                            @foreach (config('payment-methods') as $method)
                                <option value="{{ $method }}">{{ ucfirst($method) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group paid-option-fields">
                        <label><span class="text-danger pr-1">*</span> Payment Date</label>
                        <input type="datetime-local" name="payment_date"
                            value="{{ old('payment_date', now()->format('Y-m-d\TH:i')) }}"
                            class="form-control payment_date" />
                    </div>


                    <div class="form-group cancelled-option-fields">
                        <label><span class="text-danger pr-1">*</span> Reason for Cancelling</label>
                        <textarea type="text" name="reason" class="form-control reason" placeholder="Enter reason for cancelling"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm change-status-btn rounded-pill" name="ConfirmBtn"><i class="fa fa-plus-circle pr-1"></i>Submit</button>
                        <button type="reset" class="btn btn-danger btn-sm rounded-pill" data-bs-dismiss="modal">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end of modal Status - Reservation-->


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxUrl = @json(route('reservations.index.ajax'));
        const deletedSeletectedUrl = @json(route('reservations.index.ajax'));
        const cat = 'reservation';
        const token = "{{ csrf_token() }}";
        var reservation_statuses = <?php echo json_encode(config('reservation-statuses')); ?>;


        $(document).ready(function() {

            //code that displays results of the table index()
            let table = $('#reservations-table');
            let title = "List of reservations in the system";
            let columns =[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
            let dataColumns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'guest',
                    name: 'guest'
                },
                {
                    data: 'guest_type',
                    name: 'guest_type'
                },
                {
                    data: 'arrival_date',
                    name: 'arrival_date'
                },
                {
                    data: 'departure_date',
                    name: 'departure_date'
                },
                {
                    data: 'nights',
                    name: 'nights'
                },
                {
                    data: 'room_number',
                    name: 'room_number'
                },
                {
                    data: 'invoice_number',
                    name: 'invoice_number'
                },
                {
                    data: 'invoice_status',
                    name: 'invoice_status'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'tax',
                    name: 'tax'
                },
                {
                    data: 'total_amount',
                    name: 'total_amount'
                },
                // {
                //     data: 'created_by',
                //     name: 'created_by'
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            $('.paid-option-fields').hide();
            $('.cancelled-option-fields').hide();

            $('#reservation_status').on('change', function() {
                let status = $(this).val();
                if (status == reservation_statuses.completed) {
                    $('.paid-option-fields').show();
                } else {
                    $('.paid-option-fields').hide();
                }

                if (status == reservation_statuses.cancelled) {
                    $('.cancelled-option-fields').show();
                } else {
                    $('.cancelled-option-fields').hide();
                }
            });

            $('body').on('click', '#update-reservation', function(e) {
                let reservation_id = $(this).data("id");
                checkPermission(permissions.edit_reservations, function(kitchen_order) {
                    e.preventDefault();
                    confirmReservationChange(reservation_id);
                });

            });

            function confirmReservationChange(reservation_id) {
                $("#changeReservationStatus").modal('show');
                $('.change-status-btn').on('click', function() {
                    updateReservation(reservation_id);
                });
            }

            function updateReservation(id) {
                let selected_status = $('#reservation_status').val();

                if (selected_status) {

                    let isValid = validateChangeReservationStatus(selected_status);
                    if (isValid) {

                        if (confirm("Are you sure you want to mark this reservation " + selected_status + "?")) {
                            let data = {
                                status: selected_status
                            }

                            if (selected_status == reservation_statuses.completed) {
                                data.payment_method = $('.payment_method').val();
                                data.payment_date = $('.payment_date').val();
                            }

                            if (selected_status == reservation_statuses.cancelled) {
                                data.reason = $('.reason').val();
                            }

                            let url = "{{ route('reservation.status.update', ':id') }}";
                            url = url.replace(':id', id);
                            $('.change-status-btn').html('Updating...');
                            $.ajax({
                                type: "PUT",
                                url: url,
                                data: data,
                                dataType: 'json',
                                success: function(response) {
                                    let message = response.success || response.error;
                                    let type = response.success ? 'success' : 'error';

                                    $('.change-status-btn').html(
                                        '<i class="fa fa-plus-circle pr-1"></i>Submit');
                                    $('#changeReservationStatus').modal("hide");

                                    if (response.success) {
                                        let data = response.data;
                                        $('reservation_status').val('');
                                        $('payment_method').val('');
                                        resetTblInfo(data);
                                        let tbl = $('#reservations-table').DataTable();
                                        tbl.ajax.reload();
                                    }

                                    displayResponse('.response', message, type);

                                },
                                error: function(data) {
                                    console.log('Error:', data);
                                    displayResponse('.response', data.error, 'error');
                                }
                            });
                        }
                    }
                } else {
                    displayResponse(null, 'Please select order status', 'error');
                }
            }

            function validateChangeReservationStatus(status) {

                let isValidForm = false;
                if (status == reservation_statuses.completed) {
                    let payment_method = $('.payment_method').val();
                    let payment_date = $('.payment_date').val();
                    if (!payment_method) {
                        displayResponse(null, 'Please select payment method', 'error');
                    } else if (!payment_date) {
                        displayResponse(null, 'Please select payment date', 'error');
                    } else {
                        isValidForm = true;
                    }

                } else if (status == reservation_statuses.cancelled) {
                    let reason = $('.reason').val();
                    if (!reason) {
                        displayResponse(null, 'Please enter reason for cancelling order', 'error');
                    } else {
                        isValidForm = true;
                    }
                } else if (status == reservation_statuses.pending) {
                    isValidForm = true;
                }
                return isValidForm;

            }

            //Generate invoice
            $('body').on('click', '#generate-invoice', function(event) {
                let invoice_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.download_reservation_invoice, function(reservation) {
                    downloadInvoice(invoice_id);
                });
            });

            function downloadInvoice(invoice_id) {
                let url = "{{ route('invoice.generate', ':id') }}";
                url = url.replace(':id', invoice_id);

                event.preventDefault();
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {

                        let returned_url = response.url;
                        console.log('Returned url is', response.url);
                        window.open(returned_url, '_blank');
                    }
                });
            }

            //modal used to edit reservations details [each row of the tbl]
            $('body').on('click', '#edit-reservation', function(event) {
                let reservation_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('reservations.index') }}" + '/' + reservation_id + '/edit', function(
                data) {
                    $('#modalHeading').html("Edit details of reservation " + data.name + "");
                    $('.addReservationBtn').text("Edit reservation");
                    $('#addSuppliersModal').modal('show');
                    $('.reservationId').val(data.id);
                    $('.name').val(data.name);
                    $('.address').val(data.address);
                    $('.contact').val(data.contact);
                    $('.email').val(data.email);
                    $('.debt').val(data.debt);
                    $('.credit').val(data.credit);
                    DisableTableFields(false);
                    ShowBtns();
                })
            });


            //View Modal used to view each row [reservations details]
            $('body').on('click', '#view-reservation', function(event) {
                let reservation_id = $(this).data('id');
                event.preventDefault();
                $.get("{{ route('reservations.index') }}" + '/' + reservation_id + '', function(data) {
                    $('#modalHeading').html("Details of reservation " + data.name + "");
                    $('#addSuppliersModal').modal('show');
                    $('.reservationId').val(data.id);
                    $('.name').val(data.name);
                    $('.address').val(data.address);
                    $('.contact').val(data.contact);
                    $('.email').val(data.email);
                    $('.debt').val(data.debt);
                    $('.credit').val(data.credit);
                    DisableTableFields(true);
                    HideBtns();
                })
            });


            function DisableTableFields(bool) {

                $('.reservationId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addReservationBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addReservationBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function resetTblInfo(data) {
                if(data.total){
                    $('.totl_reservations').html(FormatNumber(data.total));
                }
            }

            function validateForm() {
                let name = $('.name').val();
                let address = $('.address').val();
                let contact = $('.contact').val();
                let errors = [];
                if (name.length < 1) {
                    let nameErr = "Please enter the name of the reservation";
                    errors.push(nameErr);
                }
                if (address.length < 1) {
                    let addressErr = "Please enter the address of the reservation";
                    errors.push(addressErr);
                }
                if (contact.length < 1) {
                    let contactErr = "Please enter reservation's contact";
                    errors.push(contactErr);
                }

                return errors;

            }

        });
    </script>
@endsection
