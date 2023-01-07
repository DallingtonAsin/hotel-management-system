<html>
  <head>
    <title>Hotel Invoice</title>
    <link href="{{ asset('css/reservation_invoice.css') }}" rel="stylesheet">
  </head>
  <body>
    <h1>Hotel Name</h1>
    <h2>Invoice</h2>
    <table>
      <tr>
        <th>Invoice Number:</th>
        <td>123456</td>
      </tr>
      <tr>
        <th>Date:</th>
        <td>01/01/2023</td>
      </tr>
      <tr>
        <th>Guest Information:</th>
        <td>
          <p>Name: John Doe</p>
          <p>Address: 123 Main Street, Anytown, USA</p>
          <p>Phone: 555-555-5555</p>
        </td>
      </tr>
      <tr>
        <th>Reservation Details:</th>
        <td>
          <p>Arrival Date: 01/01/2023</p>
          <p>Departure Date: 01/03/2023</p>
          <p>Room Type: Standard King</p>
          <p>Rate: $100 per night</p>
        </td>
      </tr>
    </table>
    <h3>Charges</h3>
    <table>
      <tr>
        <th>Room Charge:</th>
        <td class="text-right">$200</td>
      </tr>
      <tr>
        <th>Taxes and Fees:</th>
        <td class="text-right">$30</td>
      </tr>
      <tr>
        <th>Total:</th>
        <td class="text-right">$230</td>
      </tr>
    </table>
    <p>Thank you for choosing our hotel. We hope you had a pleasant stay.</p>
  </body>
</html>
