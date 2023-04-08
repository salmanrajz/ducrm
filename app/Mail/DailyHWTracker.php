<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class DailyHWTracker extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;

    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            // subject: 'Daily H W Tracker',
            from: new Address('hwtracker@vocus.ae', 'Home WiFi Update | Vocus'),
            subject: 'Home Wifi Tracker - Vocus',
        );
    }
        // return $this->subject($this->data['subject'])
        // ->view('email.etisalat-express')
        // ->from($this->data['send_mail'], $this->data['email_name'])
        // ->attach($this->data['pdf_location']);

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.hw-tracker',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [
        // ->attach($this->data['pdf_location']);
            $this->data['pdf_location']
        ];
    }
}
