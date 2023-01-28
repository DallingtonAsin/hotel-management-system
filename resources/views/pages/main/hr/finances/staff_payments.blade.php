@extends('layouts.master')

@section('content')
    <div class="card">
        <span class="response"></span>
        <div class="card-header row d-flex justify-content-between align-items-center">
            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Staff Payments</strong>
                    <span class="badge badge-info totl_no">
                        @isset($total_payments)
                            {{ number_format($total_payments) }}
                        @endisset
                    </span>
                </h6>
            </div>


            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-sm btn-primary mx-2" id="createNewPayment"><i
                            class="fa fa-plus-circle pr-1"></i>Add payment</button>
                </div>
            </div>

        </div>

        <div class="card-body">


            <div class="table-responsive">
                <table class="table table-bordered staff-payments-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Employee Id</th>
                            <th>Payment Category</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>PaymentSlip</th>
                            <th>is deleted</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <!--Add payment -->
    <div class="modal fade nunito-font" id="addPaymentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="paymentCategories" id="PaymentCategoriesForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new payment category</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control payment_id  payment_id" name="id" />
                        </div>


                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Staff Member</span>
                            <select class="form-control staff_id " name="staff_id">
                                <option value="">Select staff member</option>
                                @foreach ($staff as $member)
                                    <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Payment Category</span>
                            <select class="form-control category_id " name="category_id">
                                <option value="">Select payment category</option>
                                @foreach ($payment_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Amount</span>
                            <input type="text" class="form-control amount" name="amount"
                                placeholder="Enter payment amount" />
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Payment Date</span>
                            <input type="date" class="form-control payment_date" name="payment_date"
                                value="{{ old('payment_date', now()->format('Y-m-d')) }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="addPaymentBtn"
                                name="addPaymentBtn">Save</button>
                            <button type="reset" class="btn btn-danger clearBtn">Clear</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>




    <!--Modal Delete Payment Category -->

    <div class="modal fade" id="deletePaymentCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">

        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete payment</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">
                                Are you sure you want to delete this payment?

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
    </div> <!-- end of modal DeleteExpenses-->


    <script>
        const ajaxUrl = @json(route('staff.payments.ajax.fetch'));
        const cat = 'payment-categories';
        const token = "{{ csrf_token() }}";
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //code that displays results of the table index()
            let table = $('.staff-payments-table');
            let title = "List of recorded staff payments in the system";
            let columns = [0, 1, 2, 3];
            let dataColumns = [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'employee_name',
                    name: 'employee_name'
                },
                {
                    data: 'employee_id',
                    name: 'employee_id'
                },
                {
                    data: 'payment_category',
                    name: 'payment_category'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'payment_date',
                    name: 'payment_date'
                },
                {
                    data: 'payment_slip',
                    name: 'payment_slip'
                },
                {
                    data: 'is_deleted',
                    name: 'is_deleted'
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

            $('#createNewPayment').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.create_payments, function(payment) {
                    DisableFormFields(false);
                    ShowBtns();
                    $('#addPaymentBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.payment_id').val('');
                    $('#PaymentCategoriesForm').trigger("reset");
                    $('#modalHeading').html("Add new staff payment");
                    $('#addPaymentModal').modal('show');
                });
            });

            Numberize(".amount");

            //modal used to edit payment details [each row of the tbl]
            $('body').on('click', '#edit-staff-payment', function(event) {
                let payment_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_payments, function(payment) {
                    editPayment(payment_id);
                });
            });

            function editPayment(payment_id) {
                $.get("{{ route('staff-payments.index') }}" + '/' + payment_id + '/edit', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Edit details of staff payment for " + data.staff_name +
                        "");
                        $('#addPaymentBtn').text("Update");
                        $('#addPaymentModal').modal('show');
                        populatePaymentDetails(data);
                        DisableFormFields(false);
                        ShowBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }


            //View Modal used to view each row 
            $('body').on('click', '#view-staff-payment', function(event) {
                let payment_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_payments, function(staff_payment) {
                    viewPayment(payment_id);
                });
            });

            function viewPayment(payment_id) {
                $.get("{{ route('staff-payments.index') }}" + '/' + payment_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Details of payment record for " + data.staff_name + "");
                        $('#addPaymentModal').modal('show');
                        populatePaymentDetails(data);
                        DisableFormFields(true);
                        HideBtns();

                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }

            function populatePaymentDetails(data) {
                $('.payment_id').val(data.id);
                $('.staff_id').val(data.staff_id);
                $('.category_id').val(data.payment_category_id);
                $('.amount').val(FormatNumber(data.amount));
                $('.payment_date').val(data.payment_date);
            }


            $('#addPaymentBtn').click(function(e) {

                e.preventDefault();
                let isValidForm = validateForm();

                if (isValidForm) {

                    let id = $('.payment_id').val();
                    let url = "",
                        method = "";
                    if (id) {
                        url = "{{ route('staff-payments.update', ':id') }}",
                            url = url.replace(':id', id);
                        method = "PUT";
                    } else {
                        url = "{{ route('staff-payments.store') }}";
                        method = "POST";
                    }

                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#PaymentCategoriesForm').serialize(),
                        url: url,
                        type: method,
                        dataType: 'json',
                        success: function(response) {

                            let message = response.success || response.error;
                            let type = response.success ? 'success' : 'error';
                            if (response.success) {
                                let data = response.data;

                                resetTableInfo(data);
                                let tbl = $('.staff-payments-table').DataTable();
                                tbl.ajax.reload();
                                $('#PaymentCategoriesForm').trigger("reset");
                                $('#addPaymentModal').modal("hide");
                            }

                            displayResponse(null, message, type);
                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse(null, data.error, 'error');
                            $('#addPaymentBtn').html('Save Changes');
                        }
                    });
                }

            });

            //this pops up confirm delete modal
            $('body').on('click', '#delete-staff-payment', function(e) {
                let payment_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.cancel_payments, function(payment) {
                    $.get("{{ route('staff-payments.index') }}" + '/' + payment_id + '/edit',
                        function(response) {
                            if (response.success) {
                                let data = response.data;
                                let action = data.is_deleted == 1 ? 'undelete' : 'delete';
                                $("#deletePaymentCategoryModal").modal('show');
                                $(".delete-alert-text").html(
                                    `Are you sure you want to ${action} payment record for ${data.staff_name}?`
                                );
                                $('.delete-ok-btn').on('click', function() {
                                    deleteRecord(payment_id);
                                });
                            } else {
                                displayResponse(null, response.error, 'error');
                            }
                        });
                });
            });

            function deleteRecord(id) {

                let url = "{{ route('staff-payments.destroy', ':id') }}";
                url = url.replace(':id', id);

                $('.delete-ok-btn').html('Deleting...');
                $.ajax({
                    type: "DELETE",
                    url: url,
                    success: function(response) {
                        let message = response.success || response.error;
                        let type = response.success ? 'success' : 'error';

                        if (response.success) {
                            let data = response.data;
                            $('.delete-ok-btn').html('Yes');
                            $('#deletePaymentCategoryModal').modal("hide");
                            resetTableInfo(data);
                            let tbl = $('.staff-payments-table').DataTable();
                            tbl.ajax.reload();
                        }
                        displayResponse(null, message, type);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse(null, data.error, 'error');
                    }
                });
            }

            function DisableFormFields(bool) {
                $('.staff_id').attr('disabled', bool);
                $('.category_id').attr('disabled', bool);
                $('.amount').attr('disabled', bool);
                $('.payment_date').attr('disabled', bool);
            }

            function HideBtns() {
                $('#addPaymentBtn').hide();
                $('.clearBtn').hide();
            }

            function ShowBtns() {
                $('#addPaymentBtn').show();
                $('.clearBtn').show();
            }


            function resetTableInfo(response) {
                if (response.total) {
                    $('.totl_no').html(FormatNumber(response.total));
                }
            }

            function validateForm() {

                let staff_id = $('.staff_id').val();
                let category_id = $('.category_id').val();
                let amount = $('.amount').val();
                let payment_date = $('.payment_date').val();
                let isValidForm = false;

                if (staff_id.length < 1) {
                    displayResponse(null, "Please select staff member", 'error');
                } else if (category_id.length < 1) {
                    displayResponse(null, "Please select payment category", 'error');
                } else if (amount.length < 1) {
                    displayResponse(null, "Please enter amount", 'error');
                } else if (payment_date.length < 1) {
                    displayResponse(null, "Please choose payment date", 'error');
                } else {
                    isValidForm = true;
                }

                return isValidForm;
            }

            function isValidDate(value) {
                let re =
                    /^(?=\d)(?:(?:31(?!.(?:0?[2469]|11))|(?:30|29)(?!.0?2)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\x20|$))|(?:2[0-8]|1\d|0?[1-9]))([-.\/])(?:1[012]|0?[1-9])\1(?:1[6-9]|[2-9]\d)?\d\d(?:(?=\x20\d)\x20|$))?(((0?[1-9]|1[012])(:[0-5]\d){0,2}(\x20[AP]M))|([01]\d|2[0-3])(:[0-5]\d){1,2})?$/;
                let flag = re.test(value);
                return flag;
            }

        });
    </script>
@endsection
