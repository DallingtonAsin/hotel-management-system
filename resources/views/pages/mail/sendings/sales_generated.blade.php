<p><strong class="text-success">{{ $data["subject"] }}</strong></p>
<p>Hi {{ $data["receiverEmail"] }} </p>
<p> Today {{ $data["date"] }}, the amount of sales generated are {{ $data["amount"] }} 
</p>

Thanks & Regards,<br>
 @if(isset($companyData))
     {{ $companyData['company_name'] }} E-system
     @else
     {{ env('APP_NAME') }} E-system
     @endif