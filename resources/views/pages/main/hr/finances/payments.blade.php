@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Payments</strong>
                <span class="badge badge-info total_salaries">
                    @isset($total_payments)
                        {{ number_format($total_payments) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewPayment">
                <i class="fa fa-plus-circle pr-1"></i>Add payment</button>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover payments-table" id="payments-table">

                    <thead>
                        <tr>
                            <th></th>
                            <th>Guest Name</th>
                            <th>Invoice No.</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Added by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>


            </div>
        </div>
    </div>



    <!--Add Designations -->
    <div class="modal fade nunito-font addPaymentModal" id="addPaymentModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="payments" id="PaymentsForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new payment</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control paymentId bg-white paymentId" name="id"
                                placeholder="Enter payment id" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Guest</span>
                            <select class="form-control guest_section bg-white" name="guest">
                                <option value="">select guest</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Invoice No.</span>
                            <input type="text" class="form-control name bg-white invoice_id" name="invoice_id"
                            placeholder="Enter invoice number" required autofocus>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Payment method</span>
                            <select name="payment_method" class="form-control payment_method">
                                <option value="">Choose payment method</option>
                                <option>Cash</option>
                                <option>Credit Card</option>
                                <option>Mobile Money</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger">*</span> Amount</span>
                            <input type="text" class="form-control bg-white amount" name="amount"
                                placeholder="Enter salary amount" required autofocus>
                        </div>

                        <div class="form-group">
                            <span class="text-muted"><span class="text-danger pr-2">*</span>Payment Date</span>
                            <input type="date" class="form-control payment_date" name="payment_date"
                                value="{{ old('payment_date', now()->format('Y-m-d')) }}" autocomplete="on">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addPaymentBtn"
                                name="addPaymentBtn">Save</button>
                            <button type="reset" class="btn btn-danger clearBtn">Clear</button>
                        </div>

                        <div class="form-group">
                            <span class="errors-section text-danger nunito-font"></span>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Import Designations -->
    <div class="modal fade nunito-font" id="importRooms" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ Route('suppliers.import') }}" method="post" enctype="multipart/form-data"
                    name="inportExpensesForm">
                    @csrf

                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold">
                            Import an excel file of payments </h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <span>Select file for Upload</span>
                        </div>

                        <div class="form-group">
                            <input type="file" class="form-control-file @error('select_file') is-invalid @enderror"
                                name="select_file" required autofocus>
                        </div>

                        @error('select_file')
                            <div class='alert alert-danger alert-dismissible text-center' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span></button>
                                <strong>Sorry!</strong> {{ $message }}
                            </div>
                        @enderror

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--Modal Delete Designations -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete payment</h6>
                    <button type="button" class=method"close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this payment
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
    </div> <!-- end of modal Delete Designations-->

    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const ajaxUrl = @json(route('payments.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const guestsAjaxUrl = @json(route('guests.ajax.fetch'));
        const cat = 'payment';
        populateGuests();
        
        $(document).ready(function() {
            
            let table = $('#payments-table');
            let title = "List of recorded payments in the system";
            let columns = [1, 2, 3, 4, 5, 6];
            let dataColumns = [
                {
                    data: 'checkbox',
                    name: 'checkbox'
                },
                {
                    data: 'guest_name',
                    name: 'guest_name'
                },
                {
                    data: 'invoice_id',
                    name: 'invoice_id'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'method',
                    name: 'method'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'created_by',
                    name: 'created_by'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
            ];

            makeDataTable(table, title, columns, dataColumns);

            $('#addNewPayment').click(function(e) {
                e.preventDefault();
                DisableTableFields(false);
                ShowBtns();
                $('.addPaymentBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                $('.paymentId').val('');
                $('#PaymentsForm').trigger("reset");
                $('#modalHeading').html("Add new payment");
                $('#addPaymentModal').modal('show');
            });


            Numberize(".amount");

            //modal used to edit payments details [each row of the tbl]
            $('body').on('click', '#edit-payment', function(event) {
                let payment_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('payments.index') }}" + '/' + payment_id + '/edit', function(data) {

                    $('#modalHeading').html("Edit details of payment " + data.name + "");
                    $('.addPaymentBtn').text("Edit payment");
                    $('#addPaymentModal').modal('show');
                    $('.paymentId').val(data.id);
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


            //View Modal used to view each row [payments details]
            $('body').on('click', '#view-payment', function(event) {
                let payment_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('payments.index') }}" + '/' + payment_id + '', function(data) {

                    $('#modalHeading').html("Details of payment " + data.name + "");
                    $('#addPaymentModal').modal('show');
                    $('.paymentId').val(data.id);
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


            $('.addPaymentBtn').click(function(e) {

                e.preventDefault();

                let Errors = validateForm();
                if (Errors.length == 0) {
                    $(this).html('Sending..');
                    $('.errors-section').html('');

                    $.ajax({
                        data: $('#PaymentsForm').serialize(),
                        url: "{{ route('payments.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#PaymentsForm').trigger("reset");
                            $('#addPaymentModal').modal("hide");
                            let resp = data.success;
                            ShowResponse('.response', resp, 'success');
                            ResetTblInfo(data);
                            let tbl = $('#payments-table').DataTable();
                            tbl.ajax.reload();

                        },
                        error: function(data) {
                            $('#addPaymentModal').modal('hide');
                          
                            let error_message = data.error;
                            console.log('Error message:', data.error);
                            ShowResponse('.response', error_message, 'error');
                            $('.addPaymentBtn').html('Save Changes');
                        }
                    });
                } else {
                    let i;
                    let message = "";
                    for (i = 0; i < Errors.length; i++) {
                        message += Errors[i] + "<br>";
                    }
                    $('.errors-section').html(message);

                }

            });

            //this pops up confirm delete modal
            $('body').on('click', '#delete-payment', function(e) {
                let payment_id = $(this).data("id");
                e.preventDefault();
                $("#deleteSuppliersModal").modal('show');
                $(".delete-alert-text").html("Are you sure you want to delete this payment?");
                $('.delete-ok-btn').on('click', function() {
                    ListenAndDoDeletion(payment_id);
                });

            });

            function ListenAndDoDeletion(id) {
                let deleteUrl = '{{ route('payments.destroy', ':id') }}';
                deleteUrl = deleteUrl.replace(':id', id);
                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: deleteUrl,
                    success: function(data) {
                        let resp = data.success;
                        $('.delete-ok-btn').html('Yes');
                        $('#deleteSuppliersModal').modal("hide");
                        ShowResponse('.response', resp, 'success');
                        ResetTblInfo(data);
                        let tbl = $('#payments-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        ShowResponse('.response', data.error, 'error');
                    }
                });
            }

            function DisableTableFields(bool) {

                $('.paymentId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addPaymentBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addPaymentBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }

            function ShowResponse(area, message, errorType = 'error') {
                $(area).notify(message, {
                    className: errorType,
                    autoHide: true,
                    clickToHide: true,
                    autoHideDelay: 45000,
                });
            }

            function FormatNumber(number) {
                let FormattedNumber = parseFloat(number).toLocaleString('us', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                return FormattedNumber;
            }

            function ResetTblInfo(response) {
                let totl_number = FormatNumber(response.total);
                $('.total_salaries').html(totl_number);
            }

            function validateForm() {

                let guest_section = $('.guest_section').val();
                let invoice_id = $('.invoice_id').val();
                let amount = $('.amount').val();
                let payment_method = $('.payment_method').val();
                let payment_date = $('.payment_date').val();

                let errors = [];
                if (guest_section.length < 1) {
                    errors.push(`Please select guest`);
                }
                if (invoice_id.length < 1) {
                    errors.push(`Please enter invoice number`);
                }
                if (amount.length < 1) {
                    errors.push(`Please enter amount`);
                }
                if (payment_method.length < 1) {
                    errors.push(`Please select payment method`);
                }
                if (payment_date.length < 1) {
                    errors.push(`Please select payment date`);
                }
             
                return errors;

            }

            $("#removeAllSuppliers").bind("click", function() {
                RemoveAllSuppliers();
            });

            function RemoveAllSuppliers() {
                $.confirm({
                    boxWidth: '30%',
                    icon: 'fa fa-warning',
                    theme: 'light',
                    closeIcon: true,
                    draggable: true,
                    closeIconClass: 'fa fa-close text-danger',
                    title: 'Delete all payments',
                    content: 'Are you sure you want to remove all payments',
                    buttons: {
                        confirm: function() {
                            let self = this;
                            return $.ajax({
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                url: '{{ Route('suppliers.truncate') }}',
                                type: 'POST',
                                // dataType: 'json',
                            }).done(function(data) {

                                $.alert({
                                    title: 'Message',
                                    content: data.success,
                                });
                                $(".total_salaries").text(data.totl_no);
                                $(".totl_credit").text(data.totl_credit);
                                $(".totl_debt").text(data.totl_debt);
                                let tbl = $('#payments-table').DataTable();
                                tbl.ajax.reload();


                            }).fail(function(data) {
                                $.alert({
                                    title: 'Response',
                                    content: "Suppliers not deleted:" + data.fail,
                                });
                                console.log(data);

                            });

                        },
                        cancel: function() {

                        }
                    },
                });

            }
        });
    </script>
       <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
       <script src="{{ asset('vendors/notify/notify.js') }}"></script>
@endsection
