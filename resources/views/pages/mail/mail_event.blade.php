
@component('mail::panel')

<p>
	<strong class="text-success">
		{{ $subject }}
	</strong>
</p>

<p>Hi <strong>system user</strong> at {{ config('app.name') }} <br>
You are informed about a new event <strong>{{ $title }}</strong>
  </p>

  <p>
  	About the event/Description<br>
  	{{ $description }}
      <p>The event will start on <strong>{{ $start_date }}</strong> at <strong>{{ $time }}</strong> and end on
        <strong>{{ $end_date }}</strong></p>
  </p>

 <p>
 	This event has been recorded by {{ $registra }} and so for more details contact registra<br> of this event by calling on {{ $registraMobileNo }} or email at {{ $registra_email }}
 </p>

Thanks & Regards,<br>
 @if(isset($companyData))
     {{ $companyData['company_name'] }} E-system
     @else
     {{ env('APP_NAME') }} E-system
     @endif
	 <br>
@endcomponent
