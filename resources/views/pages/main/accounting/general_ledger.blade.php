@extends('layouts.master')

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
                                <button type="submit" class="btn btn-primary btn-sm mb-2">Filter Ledger</button>
                            </div>
                        </div>
                    </form>


            <div class="card">
              <div class="card-body">

                    <div class="container">
                        <h3>Hotel Casa Miltu General Ledger</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01/01/2023</td>
                                    <td>Cash</td>
                                    <td>$5,000</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>01/01/2023</td>
                                    <td>Capital Stock</td>
                                    <td></td>
                                    <td>$5,000</td>
                                </tr>
                                <tr>
                                    <td>01/02/2023</td>
                                    <td>Accounts Receivable</td>
                                    <td>$2,500</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>01/02/2023</td>
                                    <td>Service Revenue</td>
                                    <td></td>
                                    <td>$2,500</td>
                                </tr>
                                <tr>
                                    <td>01/03/2023</td>
                                    <td>Accounts Payable</td>
                                    <td></td>
                                    <td>$1,000</td>
                                </tr>
                                <tr>
                                    <td>01/03/2023</td>
                                    <td>Food and Beverage Expense</td>
                                    <td>$1,000</td>
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
