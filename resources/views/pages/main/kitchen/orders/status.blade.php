@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>{{ ucwords($status) }} kitchen orders</strong>
                <span class="badge badge-info total_kitchen_orders">
                    @isset($total_orders)
                        {{ number_format($total_orders) }}
                    @endisset
                </span>
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
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
            @include('pages.main.kitchen.orders.modals.view_order')
        </div>
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const cat = 'kitchen-orders';
        let ajaxUrl = "{{ route('orders.status.ajax', ':status') }}";
        ajaxUrl = ajaxUrl.replace(':status', "{{ request()->status }}");

        $(document).ready(function() {

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

            let table = $('#kitchen-orders-table');
            let title = "List of recorded kitchen orders in the system";
            let columns = [1, 2, 3];

            makeDataTable(table, title, columns, dataColumns);

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
                    DisableTableFields(true);
                    HideBtns();
                })
            });

            // View Modal used to view each row 
            $('body').on('click', '#view-kitchen-order', function(event) {
                let order_id = $(this).data('id') || 1;
                console.log('order id', order_id);
                event.preventDefault();
                checkPermission(permissions.view_kitchen_orders, function(stock) {
                    viewOrder(order_id);
                });
            });

            function viewOrder(order_id) {
                // ShowHideBtns('hide');
                order_id =1;
                let url = "{{ route('kitchen-orders.show', ':id') }}";
                url = url.replace(':id', order_id);
                
                $.get(url + '/' + order_id + '', function(data) {
                    console.log('order details', data);
                    let bprice = data.buying_price;
                    let sprice = data.selling_price;
                    let wprice = data.wholesale_price;
                    $('#modalHeading').html("Details of stock " + data.item + "");
                    $('#addStockModal').modal('show');
                    $('.stockId').val(stock_id);
                    $('.item_code').val(data.item_code);
                    $('.item-name').val(data.item);
                    $('.category').val(data.category);
                    $('#supplier').val(data.supplier);
                    $('.quantity').val(data.quantity);
                    $('.thresholdQty').val(data.threshold_qty)
                    $('.expiry_date').val(data.expiry_date);
                    $('.original_price').val(bprice);
                    $('.selling_price').val(sprice);
                    $('.wholesale_price').val(wprice);
                    DisableFormFields(true);
                });
            }


        });
    </script>
    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
@endsection
