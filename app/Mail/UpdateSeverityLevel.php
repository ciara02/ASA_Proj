<?php

namespace App\Mail;

use App\Models\tbl_pointSystem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateSeverityLevel extends Mailable
{
    use Queueable, SerializesModels;

    public $record;
    public $editUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(tbl_pointSystem $record, $editUrl)
    {
        $this->record = $record;
        $this->editUrl = $editUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('ASA Merit and Demerit Request')
                    ->view('EmailTemplate.Update-severity-demerit-request');
    }
}
