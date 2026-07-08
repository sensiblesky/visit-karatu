<?php

namespace App\Mail;

use App\Models\SponsorApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SponsorApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SponsorApplication $application) {}

    public function build()
    {
        return $this->subject('New sponsorship enquiry — ' . $this->application->organisation)
            ->view('emails.sponsor-application');
    }
}
