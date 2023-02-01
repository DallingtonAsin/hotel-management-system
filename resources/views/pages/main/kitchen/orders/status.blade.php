@extends('layouts.master')

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
            $('body').on('click', '#download-general-invoice', function(event) {
                let invoice_id = $(this).data('id');
                event.preventDefault();
                downloadKOInvoice(invoice_id, 'general');
            });

            function downloadKOInvoice(invoice_id, type) {

                let download_url = "{{ route('kitchen-order.invoice.generate', ':id')}}";
                download_url = download_url.replace(':id', invoice_id);
                let data =  { type: type };

                checkPermission(permissions.download_kitchen_order_invoice, function() {
                   
                    $.ajax({
                        url: download_url,
                        type: 'POST',
                        data: data,
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
@endsection
