@extends('emails.layout')

@section('body')
    <h2 style="margin:0 0 6px;font-size:20px;">New enquiry received</h2>
    <p style="margin:0 0 20px;color:#6b7280;font-size:14px;">Someone is interested in <strong>{{ $enquiry->listing->name }}</strong>.</p>

    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
        <tr><td style="padding:6px 0;color:#6b7280;width:120px;">Name</td><td style="padding:6px 0;">{{ $enquiry->name }}</td></tr>
        @if($enquiry->email)<tr><td style="padding:6px 0;color:#6b7280;">Email</td><td style="padding:6px 0;">{{ $enquiry->email }}</td></tr>@endif
        @if($enquiry->phone)<tr><td style="padding:6px 0;color:#6b7280;">Phone</td><td style="padding:6px 0;">{{ $enquiry->phone }}</td></tr>@endif
        <tr><td style="padding:6px 0;color:#6b7280;vertical-align:top;">Message</td><td style="padding:6px 0;">{{ $enquiry->message }}</td></tr>
    </table>
@endsection
