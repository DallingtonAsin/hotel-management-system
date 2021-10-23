@component('mail::panel')

<p>Hi
    <strong>{{  $content['receiverName'] }},</strong>
        <br>
  {{  $content['writing']  }}
</p>


Thanks & Regards,<br>
{{ $content['senderName'] }}<br>
{{ $content['senderEmail'] }}<br>
<strong>{{ $content['position'] }}</strong><br>

<strong>
 @if(isset($companyData))
     {{ $companyData['company_name'] }}
     @else
     {{ env('APP_NAME') }}
     @endif
</strong>

<br>

@endcomponent
