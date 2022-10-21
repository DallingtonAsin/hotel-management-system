<p>
	<strong class="text-success">
		{{ $subject }} at {{ config('app.name') }}
	</strong>
</p>

<p>Hi {{ $cashier_name }} <br>
Your personal details have been edited by {{ $registra }} today at {{ $created_at }}  </p>

<p>INFO About your Login details<br>
<strong>Username</strong>: <span>{{ $username }}</span><br>
<strong>Password</strong>: <span>{{ $password }}</span><br>
</p>

<br>
<a href="{{ url('/') }}">Click this link to login and view your profile to see changes
 made.</a>
<br>


Thanks & Regards,<br>
{{ $registra }}<br>
{{ $registraPosition }},
    @if(isset($companyData))
     {{ $companyData['company_name'] }}
     @else
     {{ env('APP_NAME') }}
     @endif
 <br>
{{ $registraEmail }}