@extends('emails.layout')

@section('body')
    <h2 style="margin:0 0 6px;font-size:20px;">New sponsorship enquiry</h2>
    <p style="margin:0 0 20px;color:#6b7280;font-size:14px;"><strong>{{ $application->organisation }}</strong> is interested in partnering with {{ setting('site_name', 'VisitKaratu') }}.</p>

    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
        <tr><td style="padding:6px 0;color:#6b7280;width:130px;">Organisation</td><td style="padding:6px 0;">{{ $application->organisation }}</td></tr>
        <tr><td style="padding:6px 0;color:#6b7280;">Contact</td><td style="padding:6px 0;">{{ $application->contact_name }}</td></tr>
        <tr><td style="padding:6px 0;color:#6b7280;">Email</td><td style="padding:6px 0;">{{ $application->email }}</td></tr>
        @if($application->phone)<tr><td style="padding:6px 0;color:#6b7280;">Phone</td><td style="padding:6px 0;">{{ $application->phone }}</td></tr>@endif
        @if($application->website_url)<tr><td style="padding:6px 0;color:#6b7280;">Website</td><td style="padding:6px 0;">{{ $application->website_url }}</td></tr>@endif
        @if($application->tier)<tr><td style="padding:6px 0;color:#6b7280;">Package</td><td style="padding:6px 0;">{{ $application->tier }}</td></tr>@endif
        @if($application->message)<tr><td style="padding:6px 0;color:#6b7280;vertical-align:top;">Message</td><td style="padding:6px 0;">{{ $application->message }}</td></tr>@endif
    </table>
@endsection
