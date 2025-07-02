<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailSender extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subject;
    public $message;

    public function __construct($data, $subject, $message)
    {
        $this->data = $data;
        $reference_num = $this->data['reference_num'];
        $this->subject = "ASA SYSTEM: Reference No: " . $reference_num . ": " . $subject; // UAT and Testing Only
        // $this->subject = "  ASA SYSTEM: Reference No: " . $reference_num . ": " . $subject; // Production
        $this->message = $message;
    }

    public function build()
    {
        $report = $this->data['report'] ?? '';
        $status = $this->data['status'] ?? '';


        if ($report === 'Support Request' && $status === 'Pending') {
            $view = 'EmailTemplate.Act-Report-Email-Forward';
        } elseif ($report === 'Support Request' && in_array($status, ['Cancelled', 'Activity Report being created','For Follow up', 'Completed'])) {
            $view = 'EmailTemplate.Act-Report-Email-Forward-2';
        } elseif (in_array($report, ['iSupport Services', 'Client Calls', 'Partner Enablement/Recruitment', 'Supporting Activity']) && $status === 'Pending') {
            $view = 'EmailTemplate.Act-Report-Email-Forward-3';
        } elseif (in_array($report, ['iSupport Services', 'Client Calls', 'Partner Enablement/Recruitment', 'Supporting Activity']) && in_array($status, ['Cancelled', 'Activity Report being created', 'For Follow up', 'Completed'])) {
            $view = 'EmailTemplate.Act-Report-Email-Forward-4';
        } elseif ($report === 'Internal Enablement' && $status === 'Pending') {
            $view = 'EmailTemplate.Act-Report-Email-Forward-5';
        } elseif ($report === 'Internal Enablement' && in_array($status, ['Cancelled', 'Activity Report being created', 'For Follow up', 'Completed' ])) {
            $view = 'EmailTemplate.Act-Report-Email-Forward-6';
        } elseif ($report === 'Skills Development' && in_array($status, ['Pending', 'Cancelled', 'Activity Report being created', 'For Follow up', 'Completed'])) {
            $view = 'EmailTemplate.Act-Report-Email-Forward-7';
        } elseif ($report === 'Others' && in_array($status, ['Pending', 'Cancelled', 'Activity Report being created', 'For Follow up', 'Completed'])) {
            $view = 'EmailTemplate.Act-Report-Email-Forward-8';
        }

        return $this->view($view)
            ->with('data', $this->data)
            ->with('message', $this->message)
            ->subject($this->subject);

    }
}