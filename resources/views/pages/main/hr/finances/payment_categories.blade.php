@extends('layouts.master')

@section('content')
    <div class="card">
        <span class="response"></span>
        <div class="card-header row d-flex justify-content-between align-items-center">
            <div class="col">
                <h6 class="text-left text-dark">
                    <i class="fa fa-home text-success"> /</i>
                    <strong>Payment Categories</strong>
                    <span class="badge badge-info total_no">
                        @isset($total_categories)
                            {{ number_format($total_categories) }}
                        @endisset
                    </span>
                </h6>
            </div>


            <div class="col">
                <div class="btn-group float-right justify-content-between mb-2">
                    <button type="button" class="btn btn-sm btn-primary mx-2" id="createNewPaymentCategory"><i
                            class="fa fa-plus-circle pr-1"></i>Add category</button>
                </div>
            </div>

        </div>

        <div class="card-body">


            <div class="table-responsive">
                <table class="table table-bordered payment-categories-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>Type</th>
                            <th>Is deleted</th>
                            <th>created by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <!--Add payment categories -->
    <div class="modal fade nunito-font" id="addPaymentCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                            <input type="hidden" class="form-control category_id" name="category_id">
                        </div>


                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Category name</span>
                            <input type="text" class="form-control category_name" name="category_name"
                                placeholder="Enter category name">
                        </div>

                        <div class="form-group">
                            <span><span class="text-danger pr-1">*</span>Transaction Type</span>
                            <select name="transaction_type" class="form-control transaction_type">
                                <option value="">Select transaction type</option>
                                <option value="credit">Credit</option>
                                <option value="debt">Debt</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="addPaymentCategoryBtn"
                                name="submit">Save</button>
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
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete payment category</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">
                                Are you sure you want to delete this payment category?

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
        const ajaxUrl = @json(route('payments.categories.ajax.fetch'));
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
            let table = $('.payment-categories-table');
            let title = "List of recorded payment categories in the system";
            let columns = [0, 1, 2, 3];
            let dataColumns = [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'transaction_type',
                    name: 'transaction_type'
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

            $('#createNewPaymentCategory').click(function(e) {
                e.preventDefault();
                checkPermission(permissions.create_payments, function(payment_category) {
                    DisableFormFields(false);
                    ShowBtns();
                    $('#addPaymentCategoryBtn').html(
                        "<i class='fa fa-plus-circle pr-1'></i>Submit");
                    $('.category_id').val('');
                    $('#PaymentCategoriesForm').trigger("reset");
                    $('#modalHeading').html("Add new payment category");
                    $('#addPaymentCategoryModal').modal('show');
                });
            });

            $('.modal').on('hidden.bs.modal', function() {
                $('.category_id').val('');
            });

            //modal used to edit payment category details [each row of the tbl]
            $('body').on('click', '#edit-payment-category', function(event) {
                let category_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.edit_payments, function(payment_category) {
                    editExpense(category_id);
                });
            });

            function editExpense(category_id) {
                $.get("{{ route('payment-categories.index') }}" + '/' + category_id + '/edit', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Edit details of payment category " + data.name + "");
                        $('#addPaymentCategoryBtn').text("Update");
                        $('#addPaymentCategoryModal').modal('show');
                        populatePaymentCatDetails(data);
                        DisableFormFields(false);
                        ShowBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }


            //View Modal used to view each row 
            $('body').on('click', '#view-payment-category', function(event) {
                let category_id = $(this).data('id');
                event.preventDefault();
                checkPermission(permissions.view_payments, function(payment_category) {
                    viewExpense(category_id);
                });
            });

            function viewExpense(category_id) {
                $.get("{{ route('payment-categories.index') }}" + '/' + category_id + '', function(response) {
                    if (response.success) {
                        let data = response.data;
                        $('#modalHeading').html("Details of payment category " + data.name + "");
                        $('#addPaymentCategoryModal').modal('show');
                        populatePaymentCatDetails(data);
                        DisableFormFields(true);
                        HideBtns();
                    } else {
                        displayResponse(null, response.error, 'error');
                    }
                });
            }

            function populatePaymentCatDetails(data) {
                $('.category_id').val(data.id);
                $('.category_name').val(data.name);
                $('.transaction_type').val(data.transaction_type);
            }


            $('#addPaymentCategoryBtn').click(function(e) {

                e.preventDefault();
                let isValidForm = validateForm();

                if (isValidForm) {

                    let id = $('.category_id').val();
                    let url = "",
                        method = "";
                    if (id) {
                        url = "{{ route('payment-categories.update', ':id') }}",
                            url = url.replace(':id', id);
                        method = "PUT";
                    } else {
                        url = "{{ route('payment-categories.store') }}";
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
                                resetTblInfo(data);
                                let tbl = $('.payment-categories-table').DataTable();
                                tbl.ajax.reload();
                                $('#PaymentCategoriesForm').trigger("reset");
                                $('#addPaymentCategoryModal').modal("hide");
                                $('.category_id').val('');
                            }

                            displayResponse(null, message, type);
                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse(null, data.error, 'error');
                            $('#addPaymentCategoryBtn').html('Save Changes');
                        }
                    });
                }

            });

            //this pops up confirm delete modal
            $('body').on('click', '#delete-payment-category', function(e) {
                let category_id = $(this).data("id");
                e.preventDefault();
                checkPermission(permissions.cancel_payments, function(payment_category) {
                    $.get("{{ route('payment-categories.index') }}" + '/' + category_id + '/edit',
                        function(response) {
                            if (response.success) {
                                let data = response.data;
                                let action = data.is_deleted == 1 ? 'undelete' : 'delete';
                                $("#deletePaymentCategoryModal").modal('show');
                                $(".delete-alert-text").html(
                                    `Are you sure you want to ${action} payment category ${data.name}?`
                                );
                                $('.delete-ok-btn').on('click', function() {
                                    deleteRecord(category_id);
                                });
                            } else {
                                displayResponse(null, response.error, 'error');
                            }
                        });
                });
            });


            function deleteRecord(id) {

                let url = "{{ route('payment-categories.destroy', ':id') }}";
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
                            resetTblInfo(data);
                            let tbl = $('.payment-categories-table').DataTable();
                            tbl.ajax.reload();
                            $('.category_id').val('');
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
                $('.category_name').attr('disabled', bool);
                $('.transaction_type').attr('disabled', bool);
            }

            function HideBtns() {
                $('#addPaymentCategoryBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('#addPaymentCategoryBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
            }


            function resetTblInfo(response) {
                if (response.total) {
                    $('.total_no').html(FormatNumber(response.total));
                }
            }

            function validateForm() {

                let category_name = $('.category_name').val();
                let transaction_type = $('.transaction_type').val();
                let isValidForm = false;

                if (category_name.length < 1) {
                    displayResponse(null, "Please enter payment category name", 'error');
                } else if (transaction_type.length < 1) {
                    displayResponse(null, "Please select transaction type", 'error');
                } else {
                    isValidForm = true;
                }

                return isValidForm;
            }

        });
    </script>
@endsection
