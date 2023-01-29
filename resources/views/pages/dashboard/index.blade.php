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
        <a href="{{ route('rooms.index') }}" class="col-md-6 col-lg-3 text-decoration-none">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-bed fa-3x"></i>
            <div class="info">
              <h4>Rooms</h4>
              <p><b>{{ $total_rooms }}</b></p>
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
            <div id="bar_chart" class="chart-card"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <div class="embed-responsive">
              <div id="pie_chart" class="chart-card"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <div class="embed-responsive">
            <div id="bar_chart" class="chart-card"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <div class="embed-responsive">
              <div id="pie_chart" class="chart-card"></div>
            </div>
          </div>
        </div>
      </div>
      
</div>

<script>
  $(document).ready(function(){
    eBarGraph('bar_chart', 'Bar Chart of Orders');
    ePieChart('pie_chart', 'Pie Chart of Bookings')
  });
</script>
