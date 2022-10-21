<p><strong class="text-success">{{ $subject }}</strong></p>
<p>Hi {{ $receiverName }} </p>
<p> {{ $writing }} </p>

Thanks & Regards,<br>
{{ $senderName }}<br>
{{ $position }}, 
    @if(isset($companyData))
     {{ $companyData['company_name'] }}
     @else
     {{ env('APP_NAME') }}
     @endif
<br>
{{ $senderEmail }}