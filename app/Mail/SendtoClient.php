<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendtoClient extends Mailable
{
    use Queueable, SerializesModels;

    public $Act_CompletionData;
    public $randomHash;

    public function __construct($Act_CompletionData, $randomHash)
    {
        $this->Act_CompletionData = $Act_CompletionData;
        $this->randomHash = $randomHash;
        $this->subject = "ASA System: VSTECS Phils., Inc. Activity Completion Acceptance";
    }

    public function build()
    {
       
        return $this->view('EmailTemplate.Send-to-Client')
        ->with('Act_CompletionData', $this->Act_CompletionData)
        ->with('randomHash', $this->randomHash)
        ->subject($this->subject);
       
    }
}


