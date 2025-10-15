<x-mail::message>
# Great News! Your Quote Has Been Approved

Hi {{ $quote->name }},

We're excited to let you know that your quote request has been approved!

## Service Details
- **Service Type:** {{ $quote->service_type->getLabel() }}
- **Scheduled Date & Time:** {{ $quote->booking_datetime->format('M d, Y h:i A') }}
- **Duration:** {{ $quote->duration }} hours
- **Service Address:** {{ $quote->address }}
- **Final Price:** ${{ number_format($quote->final_price, 2) }}

## What's Next?
Our team will arrive at your location on the scheduled date and time. Please ensure someone is available to provide access to the property.

## Preparation Tips
- Clear the work area of any personal items
- Ensure easy access to the service location
- Have any specific instructions ready for our team

If you need to reschedule or have any questions, please contact us as soon as possible.

<x-mail::button :url="config('app.url')">
Contact Us
</x-mail::button>

We look forward to providing you with excellent service!

Best regards,<br>
{{ config('app.name') }} Team
</x-mail::message>
