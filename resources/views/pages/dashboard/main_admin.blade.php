<div class="az-content-body">

      <div class="row">
        <a href="" class="col-md-6 col-lg-3 text-decoration-none">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Staff</h4>
              <p>
                <b>
               56
              </b></p>
            </div>
          </div>
        </a>
        <a href="" class="col-md-6 col-lg-3 text-decoration-none">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-bed fa-3x"></i>
            <div class="info">
              <h4>Rooms</h4>
              <p><b>67</b></p>
            </div>
          </div>
        </a>
        <a href="" class="col-md-6 col-lg-3 text-decoration-none">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-landmark fa-3x"></i>
            <div class="info">
              <h4>Bookings</h4>
              <p><b>88</b></p>
            </div>
          </div>
        </a>

        <a href="" class="col-md-6 col-lg-3 text-decoration-none">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-cart fa-3x"></i>
            <div class="info">
              <h4>Orders</h4>
              <p><b>78</b></p>
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


  <div class="row row-sm">

    <div class="col-xl-6 mg-t-15 mg-t-20">
      <div class="card">
        <div class="card-header">
          <h6 class="card-title tx-14 mg-b-5 nunito-font">Customer Satisfaction</h6>
          <p class="tx-gray-600 mg-b-0">Measures the quality or your support team’s efforts. It is important to monitor your customer satisfaction status, as the opinion...<!--  <a href="">Learn more</a> --></p>
        </div>
        <div class="card-body row pd-25">
          <div class="col-sm-8 col-md-7">
            <div id="flotPie" class="wd-100p ht-200"></div>
          </div>
          <div class="col-sm-4 col-md-5 mg-t-30 mg-sm-t-0">
            <ul class="list-unstyled">
              <li class="d-flex align-items-center"><span class="d-inline-block wd-10 ht-10 bg-purple mg-r-10"></span> Very Satisfied (26%)</li>
              <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-primary mg-r-10"></span> Satisfied (39%)</li>
              <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-teal mg-r-10"></span> Not Satisfied (20%)</li>
              <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-gray-500 mg-r-10"></span> Satisfied (15%)</li>
            </ul>
          </div>
        </div>
      </div>
    </div>


    <div class="col-gl-5 col-xl-6 mg-t-20">
      <div class="card">
        <div class="card-header">
          <h6 class="card-title tx-14 mg-b-5 nunito-font">Cashiers</h6>
          <p class="tx-gray-600 mg-b-0">Measure the performance your support persons [cashiers] spend
           attending to their work / customer.  <a href="{{ route('top-cashiers') }}"
           class="text-decoration-none">Learn More</a></p>
         </div>
         <div class="table-responsive mg-t-15">
          <table class="table table-talk-time">
            <thead>
              <tr>
                <th>ID</th>
                <th>Cashier</th>
                <th>Percentage (%)</th>
              </tr>
            </thead>
            <tbody>
              @isset($data)
              @php
              $count = 1;
              @endphp

              @foreach($data['top_cashiers'] as $element)

              <tr>
                <td>{{ $count++ }}</td>
                <td>{{ $element->cashier }}</td>
                <td>{{ $element->percent }}</td>
              </tr>
              @endforeach

              @endisset

            </tbody>
          </table>
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
