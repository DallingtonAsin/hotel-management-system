@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title mb-0 text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Kitchen Orders</strong>
                <span class="badge badge-info total_kitchen-orders">
                    @isset($total_orders)
                        {{ number_format($total_orders) }}
                    @endisset
                </span>
            </h6>
            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewDesignation">
                <i class="fa fa-plus-circle pr-1"></i>Add Kitchen Order</button>
        </div>

        <div class="card-body">

            <div class="table table-sm table-responsive">

                <table class="table table-bordered table-hover kitchen-orders-table" id="kitchen-orders-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order #</th>
                            <th>Table #</th>
                            <th>Room #</th>
                            <th>Status</th>
                            <th>Order date</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                            <td>1</td>
                            <td>5</td>
                            <td>Cheeseburger</td>
                            <td>2</td>
                            <td>
                                <span class="badge badge-warning">In Progress</span>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2</td>
                            <td>Chicken Caesar Salad</td>
                            <td>1</td>
                            <td>
                                <span class="badge badge-success">Completed</span>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>7</td>
                            <td>Spaghetti Carbonara</td>
                            <td>3</td>
                            <td>
                                <span class="badge badge-danger">Cancelled</span>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>


            </div>
        </div>
    </div>



    <!--Add Kitchen Order -->
    <div class="modal fade nunito-font addDesignationModal" id="addDesignationModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form name="kitchen-orders" id="KotForm">
                    @csrf
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new kitchen order</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control kotId bg-white kotId" name="id"
                                placeholder="Enter kot id" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="table_number"><span class="text-danger pr-1">*</span>Table Number</label>
                            <input type="text" class="form-control table_number" id="table_number" name="table_number"
                                placeholder="Enter table number">
                        </div>
                        <div class="form-group">
                            <label for="item"><span class="text-danger pr-1">*</span>Item</label>
                            <input type="text" class="form-control item" name="item" id="item"
                                placeholder="Enter item name">
                        </div>
                        <div class="form-group">
                            <label for="quantity"><span class="text-danger pr-1">*</span>Quantity</label>
                            <input type="text" class="form-control quantity" name="quantity" id="quantity"
                                placeholder="Enter quantity">
                        </div>
                        <div class="form-group">
                            <label for="status"><span class="text-danger pr-1">*</span>Status</label>
                            <select class="form-control status" name="status" id="status">
                                <option value="">Select order status</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addKotBtn" name="addKotBtn">Save</button>
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

    <!--Modal Delete Designations -->
    <div class="modal fade" id="deleteSuppliersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog" aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold">Delete kot</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger delete-alert-text">Are you sure you want to delete this kot
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


    <!--Modal Status Kitchen Order -->
    <div class="modal fade" id="changeOrderStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog"
        aria-labelledby="ModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold text-center">Update Kitchen Order
                        Status</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <div class="text-center">
                            <label class="text-danger order-status-text-alert">
                                Are you sure you want to change order status for this kot
                                <small class="text-dark text-muted bolded">
                                </small>
                                ?

                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary change-status-btn" name="ConfirmBtn">Yes</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end of modal Status - Kitchen Order-->

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const ajaxUrl = @json(route('kitchen_orders.index.ajax'));
        const deletedSeletectedUrl = @json(route('selected-suppliers.remove'));
        const departmentsAjaxUrl = @json(route('departments.ajax.fetch'));
        const cat = 'kot';
        populateDepartments();

        $(document).ready(function() {

            let table = $('#kitchen-orders-table');
            let title = "List of registered departments in the system";
            let columns = [1, 2, 3];
            let dataColumns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order_number',
                    name: 'order_number'
                },
                {
                    data: 'table_number',
                    name: 'table_number'
                },
                {
                    data: 'room_number',
                    name: 'room_number'
                },

                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'order_date',
                    name: 'order_date'
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

            $('#addNewDesignation').click(function(e) {
                e.preventDefault();
                DisableTableFields(false);
                ShowBtns();
                $('.addKotBtn').html("<i class='fa fa-plus-circle pr-1'></i>Submit");
                $('.kotId').val('');
                $('#KotForm').trigger("reset");
                $('#modalHeading').html("Add new kot");
                $('#addDesignationModal').modal('show');
            });


            Numberize(".quantity");

            //modal used to edit kitchen-orders details [each row of the tbl]
            $('body').on('click', '#edit-kot', function(event) {
                let kot_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('kitchen-orders.index') }}" + '/' + kot_id + '/edit', function(data) {

                    $('#modalHeading').html("Edit details of kot " + data.name + "");
                    $('.addKotBtn').text("Edit kot");
                    $('#addDesignationModal').modal('show');
                    $('.kotId').val(data.id);
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


            //View Modal used to view each row [kitchen-orders details]
            $('body').on('click', '#view-kot', function(event) {
                let kot_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('kitchen-orders.index') }}" + '/' + kot_id + '', function(data) {

                    $('#modalHeading').html("Details of kot " + data.name + "");
                    $('#addDesignationModal').modal('show');
                    $('.kotId').val(data.id);
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

            //Generate invoice
            $('body').on('click', '#download-invoice', function(event) {

                var invoice_id = $(this).data('id');
                let url = "{{ route('kitchen-order.invoice.generate', ':id') }}";
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
            });


            $('.addKotBtn').click(function(e) {

                e.preventDefault();

                let Errors = validateForm();
                if (Errors.length == 0) {
                    $(this).html('Sending..');

                    $.ajax({
                        data: $('#KotForm').serialize(),
                        url: "{{ route('kitchen-orders.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {

                            $('#KotForm').trigger("reset");
                            $('#addDesignationModal').modal("hide");
                            let resp = data.success;
                            displayResponse('.response', resp, 'success');
                            ResetTblInfo(data);
                            let tbl = $('#kitchen-orders-table').DataTable();
                            tbl.ajax.reload();

                        },
                        error: function(data) {
                            console.log('Error:', data.error);
                            displayResponse('.response', data.error, 'error');
                            $('.addKotBtn').html('Save Changes');
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


            $('body').on('click', '#mark-completed', function(e) {
                let kot_id = $(this).data("id");
                let status = 'completed';
                e.preventDefault();
                confirmOrderStatusChange(kot_id, status);
            });

            $('body').on('click', '#mark-cancelled', function(e) {
                let kot_id = $(this).data("id");
                let status = 'cancelled';
                e.preventDefault();
                confirmOrderStatusChange(kot_id, status);
            });


            $('body').on('click', '#mark-pending', function(e) {
                let kot_id = $(this).data("id");
                let status = 'In Progress';
                e.preventDefault();
                confirmOrderStatusChange(kot_id, status);
            });

            function confirmOrderStatusChange(kot_id, status) {
                $("#changeOrderStatusModal").modal('show');
                $(".order-status-text-alert").html(`Are you sure you want to mark this order ${status}?`);
                $('.change-status-btn').on('click', function() {
                    updateOrderStatus(kot_id, status);
                });
            }

            function updateOrderStatus(id, status) {

                let url = "{{ route('kitchen-order.status.update', ':id') }}";
                url = url.replace(':id', id);
                $('.change-status-btn').html('Updating...');
                $.ajax({
                    type: "PUT",
                    url: url,
                    data: {
                        status: status,
                    },
                    dataType: 'json',
                    success: function(data) {
                        let resp = data.success || data.error;
                        let type = data.success ? 'success' : 'error';

                        $('.change-status-btn').html('Yes');
                        $('#changeOrderStatusModal').modal("hide");
                        displayResponse('.response', resp, type);

                        if (data.success) {
                            ResetTblInfo(data);
                            let tbl = $('#kitchen-orders-table').DataTable();
                            tbl.ajax.reload();
                        }

                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            //this pops up confirm delete modal
            $('body').on('click', '#delete-kot', function(e) {
                let kot_id = $(this).data("id");
                e.preventDefault();
                $("#deleteSuppliersModal").modal('show');
                $(".delete-alert-text").html("Are you sure you want to delete this kot?");
                $('.delete-ok-btn').on('click', function() {
                    deleteRecord(kot_id);
                });

            });

            function deleteRecord(id) {
                let deleteUrl = "{{ route('kitchen-orders.destroy', ':id') }}";
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
                        let tbl = $('#kitchen-orders-table').DataTable();
                        tbl.ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            function DisableTableFields(bool) {

                $('.kotId').attr('disabled', bool);
                $('.name').attr('disabled', bool);
                $('.address').attr('disabled', bool);
                $('.contact').attr('disabled', bool);
                $('.email').attr('disabled', bool);
                $('.debt').attr('disabled', bool);
                $('.credit').attr('disabled', bool);
            }

            function HideBtns() {
                $('.addKotBtn').hide();
                $('.clearBtn').hide();
                $('.closeBtn').hide();
            }

            function ShowBtns() {
                $('.addKotBtn').show();
                $('.clearBtn').show();
                $('.closeBtn').show();
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
                $('.total_kitchen-orders').html(totl_number);
            }

            function validateForm() {

                let table_number = $('.table_number').val();
                let item = $('.item').val();
                let quantity = $('.quantity').val();
                let status = $('.status').val();

                let errors = [];
                if (table_number.length < 1) {
                    errors.push(`Please enter table number`);
                }
                if (item.length < 1) {
                    errors.push(`Please enter item`);
                }
                if (quantity.length < 1) {
                    errors.push(`Please enter quantity`);
                }
                if (status.length < 1) {
                    errors.push(`Please select status of the order`);
                }

                return errors;

            }

            $("#removeAllSuppliers").bind("click", function() {
                removeAllOrders();
            });

            function removeAllOrders() {
                $.confirm({
                    boxWidth: '30%',
                    icon: 'fa fa-warning',
                    theme: 'light',
                    closeIcon: true,
                    draggable: true,
                    closeIconClass: 'fa fa-close text-danger',
                    title: 'Delete all kitchen-orders',
                    content: 'Are you sure you want to remove all kitchen-orders',
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
                                $(".total_kitchen-orders").text(data.totl_no);
                                $(".totl_credit").text(data.totl_credit);
                                $(".totl_debt").text(data.totl_debt);
                                let tbl = $('#kitchen-orders-table').DataTable();
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
