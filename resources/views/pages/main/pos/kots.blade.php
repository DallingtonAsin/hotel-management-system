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
            <button type="button" class="btn btn-primary btn-sm outline-none ml-auto mb-2" id="addNewKitchenOrder">
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
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100 font-weight-bold" id="modalHeading">Add new kitchen order</h6>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body border border-default m-3">

                        <div class="form-group">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" class="form-control kotId bg-white kotId" name="id"
                                placeholder="Enter kot id" required autofocus>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label for="menu_items"><span class="text-danger pr-1">*</span>Menu Item</label>
                                <select name="menu_items" class="form-control menu-items-section">
                                    <option value="">Select menu item</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="price"><span class="text-danger pr-1">*</span>Price</label>
                                <input type="text" class="form-control price text-success" id="price" name="price"
                                    placeholder="Price" disabled>
                            </div>

                            <div class="col-md-4">
                                <label for="quantity"><span class="text-danger pr-1">*</span>Quantity</label>
                                <input type="text" class="form-control quantity" id="quantity" name="quantity"
                                    placeholder="Enter quantity">
                            </div>

                        </div>


                        <div class="row form-group">

                            <div class="col-md-4">
                                <label for="table_number">Table Number</label>
                                <input type="text" class="form-control table_number" id="table_number"
                                    name="table_number" placeholder="Enter table number">
                            </div>

                            <div class="col-md-4">
                                <label for="room_number">Room No</label>
                                <input type="text" class="form-control room_number" name="room_number" id="room_number"
                                    placeholder="Enter room number">
                            </div>

                            <div class="col-md-4">
                                <label for="status"><span class="text-danger pr-1">*</span>Status</label>
                                <select class="form-control status" name="status" id="status">
                                    {{-- <option value="">Select order status</option> --}}
                                    <option value="In Progress" selected>In Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>

                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary addMenuItemToCartBtn"
                                name="addKotBtn">Add</button>
                            <button type="reset" class="btn btn-danger clearBtn">Clear</button>
                        </div>

                        <div class="form-group">
                            <span class="errors-section text-danger nunito-font"></span>
                        </div>

                    </div>
                </form>

                <div class="card-body">
                    <div class="table-response">
                        <table class="table table-bordered menu-item-cart" id="menu-item-cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="menu-item-cart-body"></tbody>
                        </table>

                        <div id="totals" class="float-right">
                            <div class="d-flex"> <h5 class="mr-2">Subtotal:</h5> $<span id="subtotal">30.00</span></div>
                            <div class="d-flex"> <h5 class="mr-2">Tax (10%):</h5> $<span id="tax">3.00</span></div>
                            <div class="d-flex"> <h5 class="mr-2">Total:</h5>$<span id="total">33.00</span></div>
                        </div>
                       
                    </div>
                </div>



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
        const menuItemsAjaxUrl = @json(route('kitchen-menu-items.ajax.fetch'));
        const cat = 'kitchen-orders';
        populateMenuItems();

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

            $('#addNewKitchenOrder').click(function(e) {
                e.preventDefault();
                DisableTableFields(false);
                ShowBtns();
                $('.addMenuItemToCartBtn').html("<i class='fa fa-plus-circle pr-1'></i>Add");
                $('.kotId').val('');
                $('#KotForm').trigger("reset");
                $('#modalHeading').html("Add new kitchen order");
                $('#addDesignationModal').modal('show');
            });


            Numberize(".quantity");

            onSelectMenuItem();

            function onSelectMenuItem() {
                $('.menu-items-section').on('change', function() {
                    let menu_item_id = $(this).find(":selected").val();
                    if (menu_item_id) {
                        populateMenuItemPrice(menu_item_id);
                    }
                });
            }

            function populateMenuItemPrice(menu_item_id) {

                let url = '{{ route('menu-item.price.ajax.fetch', ':menu_item_id') }}';
                url = url.replace(':menu_item_id', menu_item_id);

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(resp) {
                        let price = JSON.parse(resp);
                        $('.price').val(price);
                    },
                    error: function(data) {
                        console.log('Error on fetching price for selected menu item', data);
                        console.log('Error:', data.error);
                        displayResponse('.response', data.error, 'error');
                    }
                });
            }

            $("form").submit(function(event) {
                event.preventDefault();
                let menu_item_id = $(".menu-items-section option:selected").val();
                if (!menu_item_id) {
                    alert('Please select menu item');
                    return;
                }
                AddMenuItemToCart(menu_item_id);
            });


            function AddMenuItemToCart(menu_item_id) {

                let quantity = $('.quantity').val();
                let table_number = $('.table_number').val();
                let room_id = $('.room_id').val();
                let status = $('.status').val();

                quantity ? quantity = Convert2Num(quantity) : quantity = 1;

                let inc = 0;

                let url = "{{ route('menu-item.get', ':menu_item_id') }}";
                url = url.replace(':menu_item_id', menu_item_id);


                $.ajax({
                    url: url,
                    type: "GET",
                    cache: false,
                    dataType: 'json',
                    success: function(dataResult) {

                        console.log(dataResult);
                        let resultData = dataResult.data;
                        let bodyData = '';

                        $.each(resultData, function(index, row) {

                            let selling_price = row.price;
                            let sub_total = Convert2Num(quantity) * selling_price;
                            let sellingPrice = FormatNumber(selling_price);

                            let subTotal = FormatNumber(sub_total);
                            let total = FormatNumber(sub_total);


                            bodyData += "<tr data-name='" + row.name + "' data-quantity='" +
                                quantity + "' data-sprice='" + selling_price + "'>"
                            bodyData += "<td>" + row.name + "</td><td>" + quantity + "</td>" +
                                "<td>" + sellingPrice + "</td><td>" + total +
                                "</td><td><button class='btn btn-sm border border-success btn-edit-cart text-success'>Edit</button>" +
                                "<button class='btn btn-sm border border-danger text-danger btn-delete-cart ml-2'>Delete</button></td>";
                            bodyData += "</tr>";

                            $('.menu-item-cart tbody tr').each(function(i, tr) {

                                const itemName = $(tr).children().eq(0).text();
                                const itemQty = $(tr).children().eq(1).text();
                                const ItemPrice = $(tr).children().eq(2).text();
                                $('.quantity').val("");

                                let newQty = Convert2Num(itemQty);

                                if (itemName == row.name) {

                                    newQty = Convert2Num(itemQty) + quantity;
                                    let newSubTotal = newQty * Convert2Num(ItemPrice);
                                    let newTotal = newSubTotal;
                                    newTotal % 1 != 0 ? newTotal = newTotal.toFixed(2) :
                                        newTotal = newTotal;

                                    $(this).children(":eq(1)").text(FormatNumber(
                                        newQty));
                                    $(this).children(":eq(3)").text(FormatNumber(
                                        newTotal));

                                    updateSubTotal();
                                    // ComputeBalance();

                                    inc += 1;
                                }

                            });

                            if (inc == 0) {
                                $(".menu-item-cart-body").append(bodyData);
                                $('.quantity').val("");
                                updateSubTotal();
                                // ComputeBalance();
                            }

                        });
                    }
                });
            }

            function updateSubTotal(){
                        let table = document.getElementById('menu-item-cart');
                        let subTotal = Array.from(table.rows).slice(1).reduce((total, row) => {
                          let Total =  row.cells[3].innerHTML;
                          let subTotl =  Total.replace(/,/g , '').trim();
                          return total + parseFloat(subTotl);
                        }, 0);
                        
                        let tax = 0.18*subTotal;
                        let total = subTotal + tax;
                        document.getElementById('subtotal').innerHTML = FormatNumber(subTotal.toFixed(0));
                        document.getElementById('tax').innerHTML = FormatNumber(tax.toFixed(0));
                        document.getElementById('total').innerHTML = FormatNumber(total.toFixed(0));
             }
                

            $(document).on("click", ".btn-edit-cart", function() {

                let quantity = $(this).parents('tr').find('td:eq(1)').html();
                let price = $(this).parents('tr').find('td:eq(2)').html();

                quantity = Convert2Num(quantity);
                price = Convert2Num(price);
                
                $(this).parents('tr').find('td:eq(1)').html('<input name="edit_quantity" class="edit_quantity" value="' + quantity + '" style="width:80px">');
                $(this).parents('tr').find('td:eq(4)').prepend('<button class="btn btn-info btn-xs btn-update-cart">Update</button><button class="btn btn-warning ml-3 btn-xs btn-cancel-cart">Cancel</button>');
                $(this).hide();
                $('.btn-delete-cart').hide();

            });

            $(document).on("click", ".btn-update-cart", function() {

                let name = $(this).parents('tr').attr('data-name');
                let quantity = $(this).parents('tr').find("input[name='edit_quantity']").val();
                let sprice = $(this).parents('tr').find('td:eq(2)').text();

                let newSubTotal = Convert2Num(quantity) * Convert2Num(sprice);
                let newTotal = newSubTotal;
                newTotal % 1 != 0 ? newTotal = newTotal.toFixed(2) : newTotal = newTotal;

                $(this).parents('tr').find('td:eq(1)').html(quantity);
                $(this).parents('tr').find('td:eq(3)').html(FormatNumber(newTotal));
                $(this).parents('tr').attr('data-quantity', quantity);

                updateSubTotal();
                // ComputeBalance();

                $(this).parents('tr').find('.btn-edit-cart').show();
                $('.btn-delete-cart').show();
                $(this).parents('tr').find('.btn-update-cart').hide();
                $(this).parents('tr').find('.btn-cancel-cart').hide();


            });


            $(document).on("click", ".btn-cancel-cart", function() {
                let quantity = $(this).parents('tr').attr('data-quantity');
                $(this).parents('tr').find('td:eq(1)').html(quantity);
                $(this).parents('tr').find('.btn-edit-cart').show();
                $(this).parents('tr').find('.btn-delete-cart').show();
                $(this).parents('tr').find('.btn-update-cart').hide();
                $(this).parents('tr').find('.btn-cancel-cart').hide();

            });

            $(document).on("click", ".btn-delete-cart", function() {
                  $(this).parent().parent('tr').remove();
                  updateSubTotal();
                //   ComputeBalance();
                });












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
