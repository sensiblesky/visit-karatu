@extends('emails.layout')

@section('body')
    <h2 style="margin:0 0 6px;font-size:20px;">New booking request</h2>
    <p style="margin:0 0 20px;color:#6b7280;font-size:14px;">A booking request came in for <strong>{{ $booking->listing->name }}</strong>.</p>

    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
        <tr><td style="padding:6px 0;color:#6b7280;width:120px;">Guest</td><td style="padding:6px 0;">{{ $booking->guest_name }}</td></tr>
        <tr><td style="padding:6px 0;color:#6b7280;">Date</td><td style="padding:6px 0;">{{ $booking->booking_date->format('d M Y') }}</td></tr>
        <tr><td style="padding:6px 0;color:#6b7280;">Guests</td><td style="padding:6px 0;">{{ $booking->adults }} adults{{ $booking->children ? ', ' . $booking->children . ' children' : '' }}</td></tr>
        @if($booking->amount)<tr><td style="padding:6px 0;color:#6b7280;">Estimate</td><td style="padding:6px 0;">${{ number_format($booking->amount, 2) }}</td></tr>@endif
        <tr><td style="padding:6px 0;color:#6b7280;">Status</td><td style="padding:6px 0;">{{ ucfirst($booking->status) }}</td></tr>
    </table>
@endsection
