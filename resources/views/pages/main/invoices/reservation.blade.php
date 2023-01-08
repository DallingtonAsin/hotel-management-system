<html>
  <head>
    <title>Hotel Invoice</title>
    <link href="{{ asset('css/reservation_invoice.css') }}" rel="stylesheet">
  </head>
  <body>
    <h1>
      @isset($company)
      @if (isset($company->name))
       {{ $company->name }}
      @else
      {{ config('app.name') }}
      @endif
 
      @endisset
    
    </h1>
    <h2>Invoice</h2>
    <table>
      <tr>
        <th>Invoice Number:</th>
        <td>{{ $invoice->id }}</td>
      </tr>
      <tr>
        <th>Date:</th>
        <td>{{ date('Y-m-d H:i A', strtotime($invoice->ts_issued)) }}</td>
      </tr>
      <tr>
        <th>Guest Information:</th>
        <td>
          <p>Name: {{$guest->first_name}} {{$guest->last_name}}</p>
          <p>Email: {{$guest->email}}</p>
          <p>Phone: {{$guest->phone_number}}</p>
        </td>
      </tr>
      <tr>
        <th>Reservation Details:</th>
        <td>
          <p>Arrival Date: {{ $reservation->arrival_date }}</p>
          <p>Departure Date: {{ $reservation->departure_date }}</p>
          <p>Room Type: {{ $room_type }}</p>
          <p>Rate: ${{ $price_rate }} per night</p>
        </td>
      </tr>
    </table>
    <h3>Charges</h3>
    <table>
      <tr>
        <th>Room Charge:</th>
        <td class="text-right">${{number_format($invoice->total)}}</td>
      </tr>
      <tr>
        <th>Taxes and Fees:</th>
        <td class="text-right">${{number_format($tax_fees)}}</td>
      </tr>
      <tr>
        <th>Total:</th>
        <td class="text-right">${{number_format($total_amount)}}</td>
      </tr>
    </table>
    <p>Thank you for choosing our hotel. We hope you had a pleasant stay.</p>
  </body>
</html>
