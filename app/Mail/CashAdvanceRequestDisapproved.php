<?php

namespace App\Mail;

use App\Models\tbl_cash_advance_request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CashAdvanceRequestDisapproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $record;
     public $role;

    public function __construct(tbl_cash_advance_request $record, $role)
    {
        $this->record = $record;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
   public function build()
    {
        return $this->subject('Cash Advance Request Disapproved - ' . $this->record->proj_ref_id)
            ->view('EmailTemplate.Cash-Approval-Request-Email-Disapproved')
            ->with([
                'record' => $this->record,
                'role' => $this->role
            ]);
    }

}
