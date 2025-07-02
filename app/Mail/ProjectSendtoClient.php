<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProjectSendtoClient extends Mailable
{
    use Queueable, SerializesModels;

    public $Approvers;
    public $Act_CompletionData;
    public $randomHash;

    public function __construct($Approvers, $Act_CompletionData, $randomHash)
    {
        $this->Approvers = $Approvers;
        $this->Act_CompletionData = $Act_CompletionData;
        $this->randomHash = $randomHash;

        $this->subject = "ASA System: VSTECS Phils., Inc. Project Completion Acceptance";
    }

    public function build()
    {

        return $this->view('EmailTemplate.SendtoClientProject')
        ->with([
            'Approvers' => $this->Approvers,
            'Act_CompletionData' => $this->Act_CompletionData,
            'randomHash' => $this->randomHash,
        ]);


    }
}
