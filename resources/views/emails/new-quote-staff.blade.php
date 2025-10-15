<x-mail::message>
# New Quote Request Received

A new quote request has been submitted and requires your attention.

## Customer Details
- **Name:** {{ $quote->name }}
- **Email:** {{ $quote->email }}
- **Phone:** {{ $quote->phone }}
- **Address:** {{ $quote->address }}

## Service Details
- **Service Type:** {{ $quote->service_type->getLabel() }}
- **Preferred Date & Time:** {{ $quote->booking_datetime->format('M d, Y h:i A') }}
- **Estimated Duration:** {{ $quote->duration }} hours
- **Estimated Price:** ${{ number_format($quote->estimated_price, 2) }}

@if($quote->additional_notes)
## Additional Notes
{{ $quote->additional_notes }}
@endif

<x-mail::button :url="config('app.url') . '/admin/quotes/' . $quote->id">
View Quote Details
</x-mail::button>

Please review and respond to this quote request promptly.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
