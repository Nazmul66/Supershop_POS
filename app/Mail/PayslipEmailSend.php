<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayslipEmailSend extends Mailable
{
    use Queueable, SerializesModels;

    public $payroll;
    public $total_earnings;
    public $total_deductions;
    public $net_salary;
    /**
     * Create a new message instance.
     */
    public function __construct($payroll, $total_earnings, $total_deductions,  $net_salary)
    {
        $this->payroll           = $payroll;
        $this->total_earnings    = $total_earnings;
        $this->total_deductions  = $total_deductions;
        $this->net_salary        = $net_salary;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payslip Email Send',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.pages.mail.payslip_email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
