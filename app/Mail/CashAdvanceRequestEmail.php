<?php

namespace App\Mail;

use App\Models\tbl_cash_advance_request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CashAdvanceRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $record;
    public $requestUrl;

    public function __construct(tbl_cash_advance_request $record, $requestUrl)
    {
        $this->record = $record;
        $this->requestUrl = $requestUrl;
    }

    public function build()
    {
        return $this->subject('Cash Advance Approval Request - ' . $this->record->proj_ref_id)
            ->view('EmailTemplate.Cash-Approval-Request-Email')
            ->with([
                'record' => $this->record,
                'approveUrl' => $this->requestUrl['approve'],
                'disapproveUrl' => $this->requestUrl['disapprove'],
                'viewUrl' => $this->requestUrl['approvalRequestView']
            ]);
    }
}
