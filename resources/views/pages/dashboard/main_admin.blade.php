<div class="az-content-header d-block d-md-flex">
  <div>
    <!-- <h2 class="az-content-title mg-b-5 mg-b-lg-8">Hi, welcome back!</h2> -->
    <p class="mg-b-0 nunito-font">Customer service/ Desk monitoring dashboard.</p>
  </div>
</div><!-- az-content-header -->
<div class="az-content-body">
  <div class="row row-sm">

    <div class="col-sm-6 col-lg-4 col-xl-3">
      <div class="card card-body card-dashboard-fifteen">
        <h1>
          @isset($data)
          {{ number_format($data['total_sales']) }}
          @endisset
        </h1>
        <label class="tx-teal nunito-font">Sales Made</label>
        <span>The total number of sales that have been made so far.</span>
        <div class="chart-wrapper">
          <div id="flotChart1" class="flot-chart"></div>
        </div><!-- chart-wrapper -->
      </div><!-- card -->
    </div><!-- col -->

    <div class="col-sm-6 col-lg-4 col-xl-3 mg-t-20 mg-sm-t-0">
      <div class="card card-body card-dashboard-fifteen">
        <h1>
          @isset($data)
          {{ number_format($data['num_of_stockItems']) }}
          @endisset
        </h1>
        <label class="tx-teal nunito-font">Stock Available</label>
        <span>The total number of items currently available in stock.</span>
        <div class="chart-wrapper">
          <div id="flotChart2" class="flot-chart"></div>
        </div><!-- chart-wrapper -->
      </div><!-- card -->
    </div><!-- col -->

    <div class="col-sm-6 col-lg-4 col-xl-3 mg-t-20 mg-sm-t-20 mg-lg-t-0">
      <div class="card card-body card-dashboard-fifteen">
        <h1>
          @isset($data)
          {{ number_format($data['total_expenses']) }}
          @endisset
          <span></span>
        </h1>
        <label class="tx-teal nunito-font">Expenses Recorded</label>
        <span>The total number of recorded expenses.</span>
        <div class="chart-wrapper">
          <div id="flotChart4" class="flot-chart"></div>
        </div><!-- chart-wrapper -->
      </div><!-- card -->
    </div><!-- col -->

    <div class="col-sm-6 col-lg-4 col-xl-3 mg-t-20 mg-sm-t-20 mg-lg-t-0">
      <div class="card card-body card-dashboard-fifteen">
        <h1>
          @isset($data)
          {{ number_format($data['total_damages']) }}
          @endisset
          <span></span>
        </h1>
        <label class="tx-teal nunito-font">Damages Recorded</label>
        <span>The total number of recorded damages in the system.</span>
        <div class="chart-wrapper">
          <div id="flotChart3" class="flot-chart"></div>
        </div><!-- chart-wrapper -->
      </div><!-- card -->
    </div><!-- col -->


    <div class="col-xl-6 mg-t-15 mg-t-20">
      <div class="card">
        <div class="card-header">
          <h6 class="card-title tx-14 mg-b-5 nunito-font">Customer Satisfaction</h6>
          <p class="tx-gray-600 mg-b-0">Measures the quality or your support team’s efforts. It is important to monitor your customer satisfaction status, as the opinion...<!--  <a href="">Learn more</a> --></p>
        </div><!-- card-header -->
        <div class="card-body row pd-25">
          <div class="col-sm-8 col-md-7">
            <div id="flotPie" class="wd-100p ht-200"></div>
          </div><!-- col -->
          <div class="col-sm-4 col-md-5 mg-t-30 mg-sm-t-0">
            <ul class="list-unstyled">
              <li class="d-flex align-items-center"><span class="d-inline-block wd-10 ht-10 bg-purple mg-r-10"></span> Very Satisfied (26%)</li>
              <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-primary mg-r-10"></span> Satisfied (39%)</li>
              <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-teal mg-r-10"></span> Not Satisfied (20%)</li>
              <li class="d-flex align-items-center mg-t-5"><span class="d-inline-block wd-10 ht-10 bg-gray-500 mg-r-10"></span> Satisfied (15%)</li>
            </ul>
          </div><!-- col -->
        </div><!-- card-body -->
      </div><!-- card -->
    </div><!-- col -->


    <div class="col-gl-5 col-xl-6 mg-t-20">
      <div class="card">
        <div class="card-header">
          <h6 class="card-title tx-14 mg-b-5 nunito-font">Cashiers</h6>
          <p class="tx-gray-600 mg-b-0">Measure the performance your support persons [cashiers] spend
           attending to their work / customer. It gives your individual insight into
           how best they invest in their work... <a href="{{ route('top-cashiers') }}"
           class="text-decoration-none">Learn More</a></p>
         </div><!-- card-header -->
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
        </div><!-- table-responsive -->
      </div><!-- card -->
    </div><!-- col -->

    <div class="col-md-5 col-lg-5 col-xl-4 mg-t-20">
      <div class="card card-dashboard-sixteen">
        <div class="card-header">
          <h6 class="card-title tx-14 mg-b-1 nunito-font text-left">Top Debtors: Customers</h6>
        </div><!-- card-header -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table mg-b-0">
              <tbody>


                @isset($data)

                @php
                $num = 1;
                @endphp

                @foreach($data['debtorsCustomers'] as $element)

                <tr>
                  <td>
                    {{ $num++ }}.
                  </td>

                  <td>
                    <h6 class="mg-b-0 tx-inverse">{{ $element->name }}</h6>
                    <small class="tx-11 tx-gray-500">Contact: {{ $element->contact }}</small>
                  </td>

                  <td>
                    <h6 class="mg-b-0 tx-inverse">{{
                      round(($element->debts/$data['totalCustomerDebts'])*100,1) }}/100</h6>
                      <small class="tx-11 tx-gray-500">% of total debts</small>
                    </td>

                  </tr>
                  @endforeach

                  @endisset

                </tbody>

                <tfooter>
                 <span>
                  <small class="tx-gray-600">Get to know who owe you money from customers
                   <a href="{{ Route('debtors-customers') }}" class="text-decoration-none">Learn more...</a></small>
                 </span>
               </tfooter>
             </table>
           </div><!-- table-responsive -->
         </div><!-- card-body -->
       </div><!-- card -->
     </div><!-- col -->


     <div class="col-md-7 col-lg-7 col-xl-8 mg-t-20">
      <div class="card">
        <div class="card-header">
          <h6 class="card-title tx-14 mg-b-5 nunito-font">Customer Complaints Comparison</h6>
          <p class="tx-gray-600 mg-b-0">Monitor the total number of complaints that are resolved and unresolved.</p>
        </div><!-- card-header -->
        <div class="card-body">
          <div class="dashboard-five-stacked-chart"><canvas id="chartStacked1"></canvas></div>
        </div><!-- card-body -->
      </div><!-- card -->
    </div><!-- col -->



  </div><!-- row -->
</div><!-- az-content-body -->

<script>
  $(document).ready(function(){
    $('.test-popup-link').magnificPopup({
      type: 'image'
       // other options
     });
  });
</script>
