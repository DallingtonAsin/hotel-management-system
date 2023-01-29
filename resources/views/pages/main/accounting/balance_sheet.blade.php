@extends('layouts.master')

@section('content')

<form class="form">
    <div class="row d-flex justify-content-between align-items-center">
      <div class="form-group col">
        <label for="startDate">Start Date</label>
        <input type="date" class="form-control" id="startDate" placeholder="Start Date">
      </div>
      <div class="form-group col">
        <label for="endDate">End Date</label>
        <input type="date" class="form-control" id="endDate" placeholder="End Date">
      </div>
      <div class="col">
        <button type="submit" class="btn btn-primary float-right btn-sm rounded-pill">Search Results</button>
      </div>
    </div>
  </form>

        <div class="card">
            <div class="card-body">
                
                <h6>Balance Sheet</h6>

                <div class="card">
                    <div class="card-body border border-success">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-success text-white">
                        <th>Asset</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>Cash</td>
                        <td>{{ $cash }}</td>
                    </tr>
                    <tr>
                        <td>Accounts Receivable</td>
                        <td>{{ $accounts_receivable }}</td>
                    </tr>
                    <tr>
                        <td>Inventory</td>
                        <td>{{ $inventory }}</td>
                    </tr>
                    <tr>
                        <td>Prepaid Expenses</td>
                        <td>{{ $prepaid_expenses }}</td>
                    </tr>
                    <tr>
                        <td>Fixed Assets</td>
                        <td>{{ $fixed_assets }}</td>
                    </tr>
                    <tr>
                        <td>Total Assets</td>
                        <td>{{ $total_assets }}</td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-success text-white">
                        <th>Liability</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>Accounts Payable</td>
                        <td>{{ $accounts_payable }}</td>
                    </tr>
                    <tr>
                        <td>Loans Payable</td>
                        <td>{{ $loans_payable }}</td>
                    </tr>
                    <tr>
                        <td>Accrued Expenses</td>
                        <td>{{ $accrued_expenses }}</td>
                    </tr>
                    <tr>
                        <td>Total Liabilities</td>
                        <td>{{ $total_liabilities }}</td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-success text-white">
                        <th>Equity</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>Capital</td>
                        <td>{{ $capital }}</td>
                    </tr>
                    <tr>
                        <td>Retained Earnings</td>
                        <td>{{ $retained_earnings }}</td>
                    </tr>
                    <tr>
                        <td>Total Equity</td>
                        <td>{{ $total_equity }}</td>
                    </tr>
                </table>
            </div>
        </div>
            </div>
        </div>
@endsection