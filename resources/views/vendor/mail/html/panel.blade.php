<table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation">
   
 <tr>
        <td class="panel-title">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="panel-item">
                       Daily Sales Report at 
                        @if(isset($companyData))
                        {{ $companyData['company_name'] }}
                        @else
                        {{ env('APP_NAME') }}
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>


    <tr>
        <td class="panel-content">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="panel-item">
                        {{ Illuminate\Mail\Markdown::parse($slot) }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>


</table>
