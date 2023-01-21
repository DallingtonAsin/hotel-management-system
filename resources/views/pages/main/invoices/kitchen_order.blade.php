<!DOCTYPE html>
<html>

<head>
    <link href="{{ asset('css/kitchen-order-invoice.css') }}" rel="stylesheet">
</head>

<body>
    <header>
        @if (isset($hotel->name))
            <h1>{{ $hotel->name }}</h1>
        @else
            <h1>{{ config('app.HOTEL_NAME') }}</h1>
        @endif

        <h2>Kitchen Order Invoice</h2>
    </header>

    <div class="row">
        <div class="col-md-6">
            <p>Order ID: {{ $kitchenOrder->order_number }}</p>
            <p>Order Date: {{ date('Y-m-d H:i A', strtotime($kitchenOrder->order_date)) }}</p>
            <p>Order Status:
                @if ($kitchenOrder->status == config('kitchen-order-statuses')['pending'])
                    <span class="text-warning">{{ ucfirst($kitchenOrder->status) }}</span>
                @endif

                @if ($kitchenOrder->status == config('kitchen-order-statuses')['completed'])
                    <span class="text-success">{{ ucfirst($kitchenOrder->status) }}</span>
                @endif

                @if ($kitchenOrder->status == config('kitchen-order-statuses')['cancelled'])
                    <span class="text-danger">{{ ucfirst($kitchenOrder->status) }}</span>
                @endif

            </p>

            @if ($type === 'general')
            <p>
                @if ($kitchenOrder->status == config('kitchen-order-statuses')['completed'])
                Payment Method:
                    <span>{{ ucwords($invoice->payment_method) }}</span>
                @endif
            </p>

            <p>
              @if ($kitchenOrder->status == config('kitchen-order-statuses')['completed'])
              Payment Date:
                  <span>{{ date('Y-m-d H:i A', strtotime($invoice->paid_at)) }}</span>
              @endif
          </p>
          @endif


            @if ($type === 'general')
                @if (isset($kitchenOrder->room_number))
                    <p>Room Number: {{ $kitchenOrder->room_number }}</p>
                @endif

                @if (isset($guest))
                    <p>Guest Name: {{ $guest->first_name }} {{ $guest->last_name }}</p>
                @endif

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
            @foreach ($order_items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->quantity) }}</td>
                    <td>{{ number_format($item->price) }}</td>
                    <td>{{ number_format($item->total) }}</td>
                </tr>
            @endforeach

            @if ($type === 'general')
                <tr>
                    <td colspan="3" class="text-right">SubTotal:</td>
                    <td>USh. <strong>{{ number_format($invoice->sub_total) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">Tax (18%):</td>
                    <td>USh. <strong>{{ number_format($invoice->tax) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">Total:</td>
                    <td>USh. <strong>{{ number_format($invoice->total) }}</strong></td>
                </tr>
            @endif
        </tbody>
    </table>

    @if ($type === 'general')
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
    @endif
</body>

</html>
