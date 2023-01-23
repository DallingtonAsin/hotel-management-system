@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title text-dark">
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
                            {{-- <th>#</th> --}}
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
    <div class="modal fade nunito-font addKitchenOrderModal" id="addKitchenOrderModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" aria-labelledby="exampleModalLabel" aria-hidden="true"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog mx-auto modal-dialog-xlg">
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
                            <input type="hidden" class="form-control kotId  kotId" name="id"
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

                            <div class="col-md-3">
                                <label for="table_number">Table Number</label>
                                <input type="text" class="form-control table_number" id="table_number"
                                    name="table_number" placeholder="Enter table number">
                            </div>

                            <div class="col-md-3">
                                <label for="room_number">Room No</label>
                                <input type="text" class="form-control room_number" name="room_number" id="room_number"
                                    placeholder="Enter room number">
                            </div>

                            <div class="col-md-3">
                                <label for="guest-">Guest Names</label>
                                <select name="guest" class="form-control guest" id="guest" disabled>
                                    <option value=""></option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="status"><span class="text-danger pr-1">*</span>Status</label>
                                <select class="form-control status" name="status" id="status">
                                    @foreach (config('kitchen-order-statuses') as $status)
                                        <option value="{{ $status }}"
                                            {{ str_contains($status, 'pending') ? 'selected' : '' }}>{{ ucwords($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-md-3">
                                <label for="customer_name">Customer Names</label>
                                <input type="text" class="form-control customer_name" name="customer_name"
                                    id="customer_name" placeholder="Enter customer names">
                            </div>

                            <div class="col-md-3">
                                <label for="room_number">Telephone Number</label>
                                <input type="text" class="form-control phone_number" name="phone_number"
                                    id="phone_number" placeholder="Enter telephone number">
                            </div>

                            <div class="col-md-3">
                                <label for="table_number">Tin Number</label>
                                <input type="text" class="form-control tin_number" id="tin_number" name="tin_number"
                                    placeholder="Enter tin number">
                            </div>


                            <div class="col-md-3">
                                <label for="room_number">Email</label>
                                <input type="email" class="form-control email" name="email" id="email"
                                    placeholder="Enter email">
                            </div>

                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-xs border border-dark text-dark addMenuItemToCartBtn"
                                name="addKotBtn">Add to Cart</button>
                            <button type="reset" class="btn btn-xs btn-danger mx-2 clearBtn">
                                <i class="fa fa-times-circle pr-1"></i>Clear</button>
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


                        <div class="d-flex justify-content-between" id="menu-cart-footer">
                            <div class="float-left">
                                <button type="submit" class="btn btn-primary submit-order-btn"><i
                                        class="fa fa-plus-circle pr-1"></i>Submit Order</button>
                            </div>
                            <div id="totals" class="float-right">
                                <div class="d-flex">
                                    <h5 class="mr-2">Subtotal:</h5> $<span id="subtotal">0.00</span>
                                </div>
                                <div class="d-flex">
                                    <h5 class="mr-2">Tax (18%):</h5> $<span id="tax">0.00</span>
                                </div>
                                <div class="d-flex">
                                    <h5 class="mr-2">Total:</h5>$<span id="total">0.00</span>
                                </div>
                            </div>
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
                    <h6 class="modal-title delete-modal-title w-100 font-weight-bold text-center">
                        Change Kitchen Order Status</h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label><span class="text-danger pr-1">*</span> Order status</label>
                        <select name="status" class="form-control order_status" id="order_status">
                            <option value="">Select order status</option>
                            @foreach (config('kitchen-order-statuses') as $status)
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
                        <textarea type="text" name="reason" class="form-control reason"
                            placeholder="Enter reason for cancelling"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary change-status-btn" name="ConfirmBtn"><i
                                class="fa fa-plus-circle pr-1"></i>Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end of modal Status - Kitchen Order-->

    @include('pages.main.kitchen.orders.modals.view_order')


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
        const searchRoomUrl = @json(route('rooms.ajax.suggest'));
        var order_statuses = <?php echo json_encode(config('kitchen-order-statuses')); ?>;

        $('.paid-option-fields').hide();
        $('.cancelled-option-fields').hide();

        $('#order_status').on('change', function() {
            let status = $(this).val();
            if (status == order_statuses.completed) {
                $('.paid-option-fields').show();
            } else {
                $('.paid-option-fields').hide();
            }

            if (status == order_statuses.cancelled) {
                $('.cancelled-option-fields').show();
            } else {
                $('.cancelled-option-fields').hide();
            }
        });

        const cat = 'kitchen-orders';
        populateMenuItems();

        hideCartFooterIfEmptyTable();

        function hideCartFooterIfEmptyTable() {
            let table = document.getElementById('menu-item-cart');
            let rowCount = (table.rows.length - 1);
            $("#menu-cart-footer").hide();
            // if(rowCount > 0){
            //     $("#menu-cart-footer").show();
            // }else{
            //     $("#menu-cart-footer").hide();
            // }
        }

        onTypingRoomNumber('.room_number', afterSelectingRoom);

        function afterSelectingRoom(data) {
            populateGuestName(data);
        }

        function populateGuestName(room_number) {

            let url = '{{ route('room.occupant.ajax.fetch', ':room_number') }}';
            url = url.replace(':room_number', room_number);

            $.ajax({
                type: "GET",
                url: url,
                success: function(resp) {

                    if (resp && resp.success) {
                        let guest = resp.data;
                        let guest_names = `${guest.first_name} ${guest.last_name}`;
                        $('.guest').empty();
                        $('.guest').append('<option value=' + guest.id + '>' + guest_names + '</option>');
                        $('.customer_name').val(guest_names);
                        if (guest.phone_number) {
                            $('.phone_number').val(guest.phone_number);
                        }
                        if (guest.email) {
                            $('.email').val(guest.email);
                        }
                        if (guest.tax_number) {
                            $('.tin_number').val(guest.tax_number);
                        }
                    } else {

                        $('.guest').empty();
                        $('.phone_number').val('');
                        $('.email').val('');
                        $('.tin_number').val('');
                        $('.customer_name').val('');
                        $('.room_number').val('');

                        let message = resp.error;
                        displayResponse(null, message, 'error');
                    }

                },
                error: function(data) {
                    console.log('Error on fetching details for the guest occupying room', data);
                    console.log('Error:', data.error);
                    displayResponse('.response', data.error, 'error');
                }
            });
        }


        $(document).ready(function() {

            let table = $('#kitchen-orders-table');
            let title = "List of recorded kitchen orders in the system";
            let columns = [1, 2, 3];
            let dataColumns = [{
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
                checkPermission(permissions.add_kitchen_orders, function(kitchen_order) {
                    $('.addMenuItemToCartBtn').html(
                        "<i class='fa fa-plus-circle pr-1'></i>Add to Cart");
                    $('.kotId').val('');
                    $('#KotForm').trigger("reset");
                    $('#modalHeading').html("Add new kitchen order");
                    $('#addKitchenOrderModal').modal('show');
                });
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

            $('.submit-order-btn').on('click', function() {
                let table = document.getElementById('menu-item-cart');
                let rowCount = (table.rows.length - 1);
                if (rowCount > 0) {
                    if (confirm("Are you sure you want to submit this order?")) {
                        submitKitchenOrder();
                    } else {
                        // do nothing
                    }
                } else {
                    alert('Add order items to the cart');
                }
            });

            // View Modal used to view each row 
            $('body').on('click', '#view-kitchen-order', function(event) {
                let order_id = $(this).data('id');
                event.preventDefault();
                let url = "{{ route('kitchen-orders.index') }}" + '/' + order_id + '';
                checkPermission(permissions.view_kitchen_orders, function(order) {
                    viewOrder(url);
                });
            });

            function submitKitchenOrder() {
                let TableData = new Array();
                let credit_arr = [];
                $('#menu-item-cart tbody tr').each(function(row, tr) {
                    TableData[row] = {
                        "item": $(tr).find('td:eq(0)').text(),
                        "quantity": $(tr).find('td:eq(1)').text(),
                        "price": $(tr).find('td:eq(2)').text(),
                        "total": $(tr).find('td:eq(2)').text(),
                    }
                });

                let table_number = $(".table_number").val();
                let room_number = $(".room_number").val();
                let guest_id = $(".guest").val();
                let customer_name = $(".customer_name").val();
                let phone_number = $(".phone_number").val();
                let tin_number = $(".tin_number").val();
                let email = $(".email").val();
                let status = $(".status").val();


                let selected_menu = JSON.stringify(TableData);
                console.log("Table data", selected_menu);

                $('.print-btn-text').html("saving...");

                let url = '{{ route('kitchen-order.submit') }}';

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        table_data: selected_menu,
                        table_number: table_number,
                        room_number: room_number,
                        guest_id: guest_id,
                        customer_name: customer_name,
                        phone_number: phone_number,
                        tin_number: tin_number,
                        email: email,
                        status: status,
                    },

                    success: function(data) {
                        console.log('Response', data);
                        let message = data.success || data.error;
                        let type = data.success ? 'success' : 'error';

                        if (data.error) {
                            alert("Error message: " + message);
                        }
                        if (data.success) {
                            EmptyCartTable();
                        }

                        displayResponse('.response', message, type);

                    },
                    error: function(data) {
                        console.log('Error data', data);
                        let message = data.response;
                        console.log('Error message', message);
                        alert("Error message: " + message);
                        displayResponse('.response', message, 'error');
                    }
                });

            }

            function EmptyCartTable() {
                let tbl = $('#kitchen-orders-table').DataTable();
                tbl.ajax.reload();
                $("#menu-item-cart > tbody").empty();
                $(".table_number").val('');
                $(".room_number").val('');
                $('.submit-order-btn').html("<i class='fa fa-plus-circle pr-1'></i>Submit Order");
                updateSubTotal();
                $("#addKitchenOrderModal").modal('hide');

            }

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

            function updateSubTotal() {
                let table = document.getElementById('menu-item-cart');
                let subTotal = Array.from(table.rows).slice(1).reduce((total, row) => {
                    let Total = row.cells[3].innerHTML;
                    let subTotl = Total.replace(/,/g, '').trim();
                    return total + parseFloat(subTotl);
                }, 0);

                let tax = 0.18 * subTotal;
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

                $(this).parents('tr').find('td:eq(1)').html(
                    '<input name="edit_quantity" class="edit_quantity" value="' + quantity +
                    '" style="width:80px">');
                $(this).parents('tr').find('td:eq(4)').prepend(
                    '<button class="btn btn-info btn-xs btn-update-cart">Update</button><button class="btn btn-warning ml-3 btn-xs btn-cancel-cart">Cancel</button>'
                );
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
                    $('#addKitchenOrderModal').modal('show');
                    $('.kotId').val(data.id);
                    $('.name').val(data.name);
                    $('.address').val(data.address);
                    $('.contact').val(data.contact);
                    $('.email').val(data.email);
                    $('.debt').val(data.debt);
                    $('.credit').val(data.credit);
                })
            });


            //View Modal used to view each row [kitchen-orders details]
            $('body').on('click', '#view-kot', function(event) {
                let kot_id = $(this).data('id');
                event.preventDefault();

                $.get("{{ route('kitchen-orders.index') }}" + '/' + kot_id + '', function(data) {

                    $('#modalHeading').html("Details of kot " + data.name + "");
                    $('#addKitchenOrderModal').modal('show');
                    $('.kotId').val(data.id);
                    $('.name').val(data.name);
                    $('.address').val(data.address);
                    $('.contact').val(data.contact);
                    $('.email').val(data.email);
                    $('.debt').val(data.debt);
                    $('.credit').val(data.credit);
                })
            });

            //Generate general invoice
            $('body').on('click', '#download-invoice', function(event) {
                let invoice_id = $(this).data('id');
                event.preventDefault();
                downloadKOT(invoice_id, 'general');
            });

            //Generate kitchen invoice
            $('body').on('click', '#download-kitchen-invoice', function(event) {
                let invoice_id = $(this).data('id');
                event.preventDefault();
                downloadKOT(invoice_id, 'kitchen');
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
                            $('#addKitchenOrderModal').modal("hide");
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




            $('body').on('click', '#change-order-status', function(e) {
                let kot_id = $(this).data("id");
                checkPermission(permissions.change_kitchen_order_status, function(kitchen_order) {
                    e.preventDefault();
                    confirmOrderStatusChange(kot_id);
                });

            });

            function confirmOrderStatusChange(kot_id) {
                $("#changeOrderStatusModal").modal('show');
                $('.change-status-btn').on('click', function() {
                    updateOrderStatus(kot_id);
                });
            }

            function updateOrderStatus(id) {
                let selected_status = $('#order_status').val();

                if (selected_status) {

                    let isValid = validateChangeOrderStatus(selected_status);
                    if (isValid) {

                        if (confirm("Are you sure you want to mark this order " + selected_status + "?")) {
                            let data = {
                                status: selected_status
                            }

                            if (selected_status == order_statuses.completed) {
                                data.payment_method = $('.payment_method').val();
                                data.payment_date = $('.payment_date').val();
                            }

                            if (selected_status == order_statuses.cancelled) {
                                data.reason = $('.reason').val();
                            }

                            let url = "{{ route('kitchen-order.status.update', ':id') }}";
                            url = url.replace(':id', id);
                            $('.change-status-btn').html('Updating...');
                            $.ajax({
                                type: "PUT",
                                url: url,
                                data: data,
                                dataType: 'json',
                                success: function(data) {
                                    let resp = data.success || data.error;
                                    let type = data.success ? 'success' : 'error';

                                    $('.change-status-btn').html(
                                        '<i class="fa fa-plus-circle pr-1"></i>Submit');
                                    $('#changeOrderStatusModal').modal("hide");

                                    if (data.success) {
                                        $('order_status').val('');
                                        $('payment_method').val('');
                                        ResetTblInfo(data);
                                        let tbl = $('#kitchen-orders-table').DataTable();
                                        tbl.ajax.reload();
                                    }

                                    displayResponse('.response', resp, type);

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

            function validateChangeOrderStatus(status) {

                let isValidForm = false;
                if (status == order_statuses.completed) {
                    let payment_method = $('.payment_method').val();
                    let payment_date = $('.payment_date').val();
                    if (!payment_method) {
                        displayResponse(null, 'Please select payment method', 'error');
                    } else if (!payment_date) {
                        displayResponse(null, 'Please select payment date', 'error');
                    } else {
                        isValidForm = true;
                    }

                } else if (status == order_statuses.cancelled) {
                    let reason = $('.reason').val();
                    if (!reason) {
                        displayResponse(null, 'Please enter reason for cancelling order', 'error');
                    } else {
                        isValidForm = true;
                    }
                } else if (status == order_statuses.pending) {
                    isValidForm = true;
                }
                return isValidForm;

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

          

        });
    </script>
    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
@endsection
