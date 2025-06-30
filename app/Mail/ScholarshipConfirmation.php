<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Scholarship;

class ScholarshipConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $scholarship;
    public $reviewTimeline;

    public function __construct(Scholarship $scholarship)
    {
        $this->scholarship = $scholarship;
        $this->reviewTimeline = "2-3 weeks";
    }

    public function build()
    {
        return $this->markdown('emails.scholarship.confirmation')
                    ->subject('FCC Scholarship Application Received - Under Review');
    }
}
