@extends('layouts.master')

@section('content')
    <div class="card border border-success">
        <div class="card-header">
            <h6 class="card-title">
                <i class="fa fa-chart-line text-success pr-2"></i>
                Monthly Expenses Report
            </h6>
        </div>


        <div class="row mx-2 my-3">

            <div class="col-lg-6">
                <div class="tile">
                    <div class="embed-responsive">
                        <div id="monthly_expenses_bar_chart" class="chart-card"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="tile">
                    <div class="embed-responsive">
                        <div id="monthly_expenses_line_chart" class="chart-card"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="tile">
                    <div class="embed-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="monthly-expenses-table">
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="tile">
                    <div class="embed-responsive">
                        <div id="monthly_expenses_pie_chart" class="chart-card"></div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            const ajaxUrl = @json(route('reports.expenses.monthly.ajax'));
            const cat = 'monthly-expenses';
            const token = "{{ csrf_token() }}";
            var title = "Monthly Expenses Report";
            var table = $('#monthly-expenses-table');
            var columns = [0, 1, 2, 3];

            var dataColumns = [
                {
                    data: 'year',
                    name: 'year'
                },
                {
                    data: 'month_name',
                    name: 'month_name'
                },
                {
                    data: 'total',
                    name: 'total'
                },
            ];

            reportDataTable(table, title, columns, dataColumns);

            let monthly_expenses = {!! json_encode($monthly_expenses) !!};
            let piechart_data = {!! json_encode($piechart_data) !!};


            if (monthly_expenses != undefined || monthly_expenses.length > 0) {
                eBarGraph('monthly_expenses_bar_chart', 'Bargraph', monthly_expenses.expenses,
                    monthly_expenses.months, 'expenses', '#0dcaf0');
            }

            if (monthly_expenses != undefined || monthly_expenses.length > 0) {
                eLineGraph('monthly_expenses_line_chart', 'Linegraph', monthly_expenses.expenses,
                    monthly_expenses.months, 'expenses', '#198754');
            }

            if (piechart_data != undefined || piechart_data.length > 0) {
                ePieChart('monthly_expenses_pie_chart', 'Piechart', piechart_data);
            }
        </script>
    @endsection
