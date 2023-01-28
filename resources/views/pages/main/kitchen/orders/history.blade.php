@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <span class="response"></span>
            <h6 class="card-title text-dark">
                <i class="fa fa-home text-success"> /</i>
                <strong>Kitchen Order History</strong>
                <span class="badge badge-info total_kitchen-orders">
                    @isset($total_orders)
                        {{ number_format($total_orders) }}
                    @endisset
                </span>
            </h6>
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

            @include('pages.main.kitchen.orders.modals.view_order')


        </div>
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const ajaxUrl = @json(route('kitchen-order-history.ajax'));
        const cat = 'kitchen-order-history';

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
                let order_id = $(this).data('id');
                event.preventDefault();
                let url = "{{ route('kitchen-orders.index') }}" + '/' + order_id + '';
                checkPermission(permissions.view_kitchen_orders, function(order) {
                    viewOrder(url);
                });
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

            function downloadKOT(invoice_id, type) {
                let url = "{{ route('kitchen-order.invoice.generate', ':id') }}";
                url = url.replace(':id', invoice_id);
                checkPermission(permissions.download_kitchen_order_invoice, function(kitchen_order) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            type: type,
                        },
                        success: function(response) {
                            let returned_url = response.url;
                            console.log('Returned url is', response.url);
                            window.open(returned_url, '_blank');
                        }
                    });
                });
            }

        });
    </script>
    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('vendors/notify/notify.js') }}"></script>
@endsection
