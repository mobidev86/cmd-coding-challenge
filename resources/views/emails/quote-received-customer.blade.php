<x-mail::message>
# Thank You for Your Quote Request!

Hi {{ $quote->name }},

We've received your quote request and appreciate your interest in our services. Our team will review your request and get back to you within 24 hours.

## Your Request Details
- **Service Type:** {{ $quote->service_type->getLabel() }}
- **Preferred Date & Time:** {{ $quote->booking_datetime->format('M d, Y h:i A') }}
- **Estimated Duration:** {{ $quote->duration }} hours
- **Service Address:** {{ $quote->address }}

@if($quote->additional_notes)
- **Additional Notes:** {{ $quote->additional_notes }}
@endif

## What Happens Next?
1. Our team will review your request
2. We'll prepare a detailed quote based on your requirements
3. You'll receive a response within 24 hours
4. Once approved, we'll schedule your service

If you have any questions or need to make changes to your request, please don't hesitate to contact us.

<x-mail::panel>
**Contact Information:**
- Email: {{ config('mail.from.address') }}
- Phone: (555) 123-4567
</x-mail::panel>

Thank you for choosing our services!

Best regards,<br>
{{ config('app.name') }} Team
</x-mail::message>
