<!DOCTYPE html>
<html>
  <head>
    <link href="{{ asset('css/kitchen-order-invoice.css') }}" rel="stylesheet">
  </head>
  <body>
    <header>
      @if(isset($hotel->name))
      <h1>{{ $hotel->name }}</h1>
     @else
      <h1>{{ config('app.HOTEL_NAME') }}</h1>
     @endif

      <h2>Kitchen Order Invoice</h2>
    </header>

      <div class="row">
        <div class="col-md-6">
          <p>Order ID: {{ $kitchenOrder->order_number }}</p>
          <p>Order Date: {{ $kitchenOrder->order_date }}</p>
          @if(isset($kitchenOrder->room_number))
          <p>Room Number: {{ $kitchenOrder->room_number }}</p>
          @endif
  
          @if(isset($guest))
          <p>Guest Name: {{ $guest->first_name }} {{ $guest->last_name }}</p>
          @endif
        </div>
      
      </div>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Item</th>
          <th>Quantity</th>
          <th>Price (Ush)</th>
          <th>Total (Ush)</th>
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
          <td colspan="3" class="text-right">SubTotal:</td>
          <td>USh. <strong>{{ number_format($invoice->subtotal) }}</strong></td>
        </tr>
        <tr>
          <td colspan="3" class="text-right">Tax (18%):</td>
          <td>USh. <strong>{{ number_format($invoice->tax) }}</strong></td>
        </tr>
        <tr>
          <td colspan="3" class="text-right">Total:</td>
          <td>USh. <strong>{{ number_format($invoice->total) }}</strong></td>
        </tr>
      </tbody>
    </table>
    <div class="footer"></div>
    <footer>
      @if (isset($hotel->name))
      <p>{{ $hotel->name }}</p>
     @else
      <p>{{ config('app.HOTEL_NAME') }}</p>
     @endif

     @if (isset($hotel->city))
     <p>{{ $hotel->city }}</p>
    @else
     <p>{{ config('app.HOTEL_ADDRESS') }}</p>
    @endif

    @if (isset($hotel->phone_number))
    <p>{{ $hotel->phone_number }}</p>
   @else
    <p>{{ config('app.HOTEL_PHONE_NUMBER') }}</p>
   @endif

   @if (isset($hotel->email))
   <p>{{ $hotel->email }}</p>
  @else
   <p>{{ config('app.HOTEL_EMAIL') }}</p>
  @endif

    </footer>
  </body>
</html>