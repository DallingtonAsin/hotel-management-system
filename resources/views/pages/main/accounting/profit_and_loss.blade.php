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
            <div class="container-fluid">
                <h3>Profit and Loss Statement</h3>
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr class="bg-success text-white">
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
@endsection
