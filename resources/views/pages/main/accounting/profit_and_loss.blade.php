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
                        <button type="submit" class="btn btn-primary btn-sm mb-2">Filter P&L</button>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <h1>Profit and Loss Statement</h1>
                        <table class="table">
                          <thead class="thead-light">
                            <tr>
                              <th scope="col">Description</th>
                              <th scope="col">Revenue</th>
                              <th scope="col">Expenses</th>
                              <th scope="col">Profit/Loss</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Sales</td>
                              <td>$10,000</td>
                              <td>$5,000</td>
                              <td>$5,000</td>
                            </tr>
                            <tr>
                              <td>Cost of Goods Sold</td>
                              <td>$5,000</td>
                              <td>$3,000</td>
                              <td>$2,000</td>
                            </tr>
                            <tr>
                              <td>Gross Profit</td>
                              <td>$5,000</td>
                              <td>$0</td>
                              <td>$5,000</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                </div>
            </div>
        </div>
    </div>
@endsection
