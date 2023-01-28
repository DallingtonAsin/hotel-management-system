@extends('layouts.master')

@section('content')

<div class="card">
  <div class="card-header">
   <div class="card-title nunito-font">
      <strong>
        <i class="fa fa-chart-line text-success pr-2"></i> 
        Monthly Expenses Report
      </strong>
  </div>
</div>

<div class="card-body">
  <div class="table-responsive">
    <table class="table table-bordered" id="monthly-expenses-table">
      <thead>
        <tr>
          <th>No.</th>
          <th>Year</th>
          <th>Month</th>
          <th>Total</th>
        </tr>
      </thead>
  </table>
</div>
</div>
</div>


<script>

 const ajaxUrl = @json(route('reports.expenses.monthly.ajax'));
 const cat = 'monthly-expenses';
 const token = "{{ csrf_token() }}";
 var title = "Monthly Expenses Report";
 var table = $('#monthly-expenses-table');
 var columns = [0,1,2,3];

 var dataColumns = [
  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
  {data: 'year', name:'year'},
  {data: 'month_name', name:'month_name'},
  {data: 'total', name:'total'},
  ];

  makeDataTable2(table, title, columns, dataColumns);

</script>

@endsection

