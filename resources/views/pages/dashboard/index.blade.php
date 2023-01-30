<div class="az-content-body dashboard-body">

    <div class="row">
        <a href="{{ route('staff.index') }}" class="col-md-6 col-lg-3 text-decoration-none">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <h4>Staff</h4>
                    <p><b>{{ $total_staff }}</b></p>
                </div>
            </div>
        </a>


        <a href="{{ route('reservations.index') }}" class="col-md-6 col-lg-3 text-decoration-none">
            <div class="widget-small warning coloured-icon"><i class="icon fa fa-landmark fa-3x"></i>
                <div class="info">
                    <h4>Reservations</h4>
                    <p><b>{{ $total_bookings }}</b></p>
                </div>
            </div>
        </a>


        <a href="{{ route('rooms.index') }}" class="col-md-6 col-lg-3 text-decoration-none">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-bed fa-3x"></i>
                <div class="info">
                    <h4>Rooms</h4>
                    <p><b>{{ $total_rooms }}</b></p>
                </div>
            </div>
        </a>

        <a href="{{ route('guests.index') }}" class="col-md-6 col-lg-3 text-decoration-none">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-cart fa-3x"></i>
                <div class="info">
                    <h4>Guests</h4>
                    <p><b>{{ $total_guests }}</b></p>
                </div>
            </div>
        </a>

    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <div class="embed-responsive">
                    <div id="monthly_order_chart" class="chart-card"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <div class="embed-responsive">
                    <div id="paid_order_chart" class="chart-card"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <div class="embed-responsive">
                    <div id="cancelled_order_chart" class="chart-card"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <div class="embed-responsive">
                    <div id="overview_chart" class="chart-card"></div>
                </div>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript">
    $(document).ready(function() {

        let monthly_orders = {!! json_encode($monthly_kitchen_orders) !!};
        let paid_orders = {!! json_encode($paid_monthly_kitchen_orders) !!};
        let cancelled_orders = {!! json_encode($cancelled_monthly_kitchen_orders) !!};
        let completed_orders = {!! json_encode($completed_kitchen_orders) !!};

        console.log('Monthly orders', monthly_orders.length);
        console.log('Paid orders', paid_orders);
        console.log('Cancelled orders', cancelled_orders);
        console.log('Completed orders', completed_orders);



        if (monthly_orders != undefined || monthly_orders.length > 0) {
            eBarGraph('monthly_order_chart', 'Monthly Kitchen Orders', monthly_orders.orders, monthly_orders.months, 'orders', '#0dcaf0');
        }

        if (paid_orders != undefined || paid_orders.length > 0) {
            ePieChart('paid_order_chart', 'Monthly Paid Kitchen Orders', paid_orders);
        }

        if (cancelled_orders != undefined || cancelled_orders.length > 0) {
            eLineGraph('cancelled_order_chart', 'Monthly Cancelled Kitchen Orders', cancelled_orders.orders, cancelled_orders.months, 'orders', '#dc3545');
        }

      
        if ((monthly_orders != undefined || monthly_orders.length > 0) && 
        (completed_orders != undefined || completed_orders.length > 0) && 
        (cancelled_orders != undefined || cancelled_orders.length > 0 )) {

            let metricsData = [];
            let metrics = ["Total orders", "Paid orders", "Cancelled orders"];
            let title = "Total Orders vs Paid Orders vs Cancelled Orders";

            metricsData[0] = monthly_orders.orders;
            metricsData[1] = completed_orders.orders;
            metricsData[2] = cancelled_orders.orders;
            get2BarsAndLineGraphOptions('overview_chart', title, metrics, monthly_orders.months, metricsData);
        }else{
          console.log("monthly orders", monthly_orders.length);
          console.log("completed orders", completed_orders.length);
          console.log("cancelled orders", cancelled_orders.length);

        }

    });
</script>
