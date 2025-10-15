<x-mail::message>
# Quote Request Update

Hi {{ $quote->name }},

Thank you for your interest in our services. After reviewing your quote request, we're unable to proceed with this particular request.

## Request Details
- **Service Type:** {{ $quote->service_type->getLabel() }}
- **Requested Date & Time:** {{ $quote->booking_datetime->format('M d, Y h:i A') }}
- **Service Address:** {{ $quote->address }}

@if($quote->rejection_reason)
## Reason
{{ $quote->rejection_reason }}
@endif

## Alternative Options
We'd still love to help you with your property service needs. Please consider:

- **Different dates:** We may have availability on alternative dates
- **Modified service scope:** We can discuss adjusting the service requirements
- **Future scheduling:** Contact us for availability in the coming weeks

<x-mail::button :url="config('app.url')">
Submit New Request
</x-mail::button>

If you have any questions or would like to discuss alternatives, please don't hesitate to reach out.

<x-mail::panel>
**Contact Information:**
- Email: {{ config('mail.from.address') }}
- Phone: (555) 123-4567
</x-mail::panel>

Thank you for your understanding.

Best regards,<br>
{{ config('app.name') }} Team
</x-mail::message>
