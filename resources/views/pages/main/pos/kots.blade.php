@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="container">
            <h3 class="px-2 py-2">Kitchen Orders</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Table #</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>5</td>
                        <td>Cheeseburger</td>
                        <td>2</td>
                        <td>
                            <span class="badge badge-warning">In Progress</span>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>2</td>
                        <td>Chicken Caesar Salad</td>
                        <td>1</td>
                        <td>
                            <span class="badge badge-success">Completed</span>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>7</td>
                        <td>Spaghetti Carbonara</td>
                        <td>3</td>
                        <td>
                            <span class="badge badge-danger">Cancelled</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection