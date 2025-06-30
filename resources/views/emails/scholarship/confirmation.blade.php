@component('mail::message')
# FCC Scholarship Application Received

Hello {{ $scholarship->first_name }},

We've successfully received your scholarship application and it's now being reviewed by our committee.

## Application Details
- **Name:** {{ $scholarship->first_name }} {{ $scholarship->middle_name }} {{ $scholarship->last_name }}
- **Email:** {{ $scholarship->email }}
- **Contact Number:** {{ $scholarship->contact_number }}
- **Date Submitted:** {{ $scholarship->created_at->format('F j, Y') }}

## What's Next?
Our review process typically takes {{ $reviewTimeline }}. You'll be notified via email once a decision has been made.

@component('mail::panel')
**Important:** Please ensure your contact information remains current during this period.
@endcomponent

If you have any questions, please contact our scholarship committee at scholarship@fccbugayong.com.

Thanks,
**FCC Bugayong Scholarship Committee**

@component('mail::button', ['url' => config('app.url')])
Visit Our Website
@endcomponent
@endcomponent
