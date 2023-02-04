@extends('layouts.master')

@section('content')
    <div class="card border border-success">
        <div class="card-header">
            <h6 class="card-title">
                <i class="fa fa-chart-line text-success pr-2"></i>
                Monthly Accomodation Revenue Report
            </h6>
        </div>


        <div class="row mx-2 my-3">

            <div class="col-lg-6">
                <div class="tile">
                    <div class="embed-responsive">
                        <div id="bar_chart" class="chart-card"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="tile">
                    <div class="embed-responsive">
                        <div id="line_chart" class="chart-card"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="tile">
                    <div class="embed-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="monthly-accomodation-revenue-table">
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
                        <div id="pie_chart" class="chart-card"></div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            const ajaxUrl = @json(route('reports.revenue.accomodation.monthly.ajax'));
            const cat = 'monthly-accomodation-revenue';
            const token = "{{ csrf_token() }}";
            var title = "Monthly Accomodation Revenue Report";
            var table = $('#monthly-accomodation-revenue-table');
            var columns = [0, 1, 2, 3];

            var dataColumns = [
                {
                    data: 'year',
                    name: 'year'
                },
                {
                    data: 'month',
                    name: 'month'
                },
                {
                    data: 'revenue',
                    name: 'revenue'
                },
            ];

            reportDataTable(table, title, columns, dataColumns);

            let report = {!! json_encode($report) !!};
            let piechart_data = {!! json_encode($piechart_data) !!};


            if (report != undefined || report.length > 0) {
                eBarGraph('bar_chart', 'Bargraph', report.revenue,
                    report.months, 'revenue', '#198754');
            }

            if (report != undefined || report.length > 0) {
                eLineGraph('line_chart', 'Linegraph', report.revenue,
                    report.months, 'revenue', '#0dcaf0');
            }

            if (piechart_data != undefined || piechart_data.length > 0) {
                ePieChart('pie_chart', 'Piechart', piechart_data);
            }
        </script>
    @endsection
