@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-body">
            <form>
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label class="sr-only" for="startDate">Start Date</label>
                        <input type="date" class="form-control mb-2" id="startDate" placeholder="Start Date">
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="endDate">End Date</label>
                        <input type="date" class="form-control mb-2" id="endDate" placeholder="End Date">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm mb-2">Filter Statement</button>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <h5>Hotel Casa Miltu Cash Flow Statement</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="2">Cash Flow from Operating Activities</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Net income</td>
                                    <td>$50,000</td>
                                </tr>
                                <tr>
                                    <td>Adjustments for:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Depreciation</td>
                                    <td>$10,000</td>
                                </tr>
                                <tr>
                                    <td>Amortization</td>
                                    <td>$5,000</td>
                                </tr>
                                <tr>
                                    <td>Loss on disposal of assets</td>
                                    <td>$1,000</td>
                                </tr>
                                <tr>
                                    <td>Changes in operating assets and liabilities:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Increase in accounts receivable</td>
                                    <td>($5,000)</td>
                                </tr>
                                <tr>
                                    <td>Decrease in inventory</td>
                                    <td>$3,000</td>
                                </tr>
                                <tr>
                                    <td>Decrease in prepaid expenses</td>
                                    <td>($1,000)</td>
                                </tr>
                                <tr>
                                    <td>Increase in accounts payable</td>
                                    <td>$2,000</td>
                                </tr>
                                <tr>
                                    <td>Net cash provided by operating activities</td>
                                    <td>$53,000</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="2">Cash Flow from Investing Activities</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Purchase of fixed assets</td>
                                    <td>($40,000)</td>
                                </tr>
                                <tr>
                                    <td>Proceeds from sale of assets</td>
                                    <td>$20,000</td>
                                </tr>
                                <tr>
                                    <td>Net cash used in investing activities</td>
                                    <td>($20,000)</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="2">Cash Flow from Financing Activities</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Proceeds from borrowing</td>
                                    <td>$30,000</td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
