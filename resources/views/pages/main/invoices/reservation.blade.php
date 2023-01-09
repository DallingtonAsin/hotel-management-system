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
        <td>{{ $invoice->invoice_number }}</td>
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

          @if($is_corporate == true)
          <p>Company Name: {{$guest->company_name}}</p>
          <p>Company Phone: {{$guest->company_contact}}</p>
          <p>Company Email: {{$guest->company_email}}</p>
          <p>TIN: {{$guest->tax_number}}</p>
          @endif

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
        <td class="text-right">${{number_format($invoice->amount)}}</td>
      </tr>
      <tr>
        <th>Tax Fees:</th>
        <td class="text-right">${{number_format($invoice->tax)}}</td>
      </tr>
      <tr>
        <th>Total:</th>
        <td class="text-right">${{number_format($invoice->total_amount)}}</td>
      </tr>
    </table>
    <p>Thank you for choosing our hotel. We hope you had a pleasant stay.</p>
  </body>
</html>
