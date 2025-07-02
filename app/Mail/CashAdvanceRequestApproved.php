<?php

namespace App\Mail;

use App\Models\tbl_cash_advance_request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CashAdvanceRequestApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $record;
    public $requestUrl;
    public $role;
    public function __construct(tbl_cash_advance_request $record, $requestUrl, $role)
    {
        $this->record = $record;
        $this->requestUrl = $requestUrl;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Cash Advance Request Approved - ' . $this->record->proj_ref_id)
        ->view('EmailTemplate.Cash-Approval-Request-Email-Approved')
        ->with([
            'record' => $this->record,
            'approveUrl' => $this->requestUrl['approve'],
            'disapproveUrl' => $this->requestUrl['disapprove'],
            'viewUrl' => $this->requestUrl['approvalRequestView'],
            'role' => $this->role
        ]);
    }
}
