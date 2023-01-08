@extends('layouts.template')

@section('content')

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h6>Balance Sheet</h6>
            </div>
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
                        <button type="submit" class="btn btn-primary btn-sm mb-2">Filter</button>
                      </div>
                    </div>
                  </form>

                <div class="card">
                    <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Asset</th>
                        <th>Amount</th>
                    </tr>
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

                <table class="table">
                    <tr>
                        <th>Liability</th>
                        <th>Amount</th>
                    </tr>
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

                <table class="table">
                    <tr>
                        <th>Equity</th>
                        <th>Amount</th>
                    </tr>
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