<!DOCTYPE html>
<html>
<head>
  <title>Kitchen Order Invoice</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-center">Casa Miltu Hotel Kitchen Order Invoice</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <p>Order ID: {{ $kitchenOrder->order_number }}</p>
        <p>Order Date: {{ $kitchenOrder->order_date }}</p>
        <p>Room Number: {{ $kitchenOrder->room_id }}</p>
        {{-- <p>Guest Name: {{ $order->guest_name }}</p> --}}
      </div>
      <div class="col-md-6">
        {{-- <p>Hotel Name: {{ $hotel->name }}</p>
        <p>Address: {{ $hotel->address }}</p>
        <p>Phone: {{ $hotel->phone }}</p>
        <p>Email: {{ $hotel->email }}</p> --}}
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Item</th>
              <th>Quantity</th>
              <th>Price($)</th>
              <th>Total($)</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order_items as $item)
              <tr>
                <td>{{ $item->name }}</td>
                <td>{{ number_format($item->quantity) }}</td>
                <td>{{ number_format($item->price) }}</td>
                <td>{{ number_format($item->total) }}</td>
              </tr>
            @endforeach
            <tr>
              <td colspan="3" class="text-right">Total:</td>
              <td>{{ number_format($invoice->total) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>


{{-- <!DOCTYPE html>
<html>
<head>
  <title>Hotel Kitchen Order Invoice</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    h1, h2, h3 {
      text-align: center;
    }
  </style>
</head>
<body>
  <h1>Casa Miltu Hotel Kitchen Order Invoice</h1>
  <h2>Invoice Number: [invoice_number]</h2>
  <h3>Date: [date]</h3>
  <table>
    <tr>
      <th>Item</th>
      <th>Quantity</th>
      <th>Price</th>
      <th>Total</th>
    </tr>
    [items]
    <tr>
      <td colspan="3">Subtotal</td>
      <td>[subtotal]</td>
    </tr>
    <tr>
      <td colspan="3">Tax</td>
      <td>[tax]</td>
    </tr>
    <tr>
      <td colspan="3">Total</td>
      <td>[total]</td>
    </tr>
  </table>
  <br>
  <h3>Customer Details</h3>
  <p>Name: [customer_name]</p>
  <p>Email: [customer_email]</p>
  <p>Phone: [customer_phone]</p>
  <p>Room Number: [customer_room_number]</p>
</body>
</html> --}}
