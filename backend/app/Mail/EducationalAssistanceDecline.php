<?php

namespace App\Mail;

use App\Models\Logo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EducationalAssistanceDecline extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $decline;
    /**
     * Create a new message instance.
     */
    public function __construct($firstname, $decline)
    {

        $this->firstname = $firstname;
        $this->decline = $decline;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $message = "
        <html>
            <head>
                <style>
                    /* Add your custom CSS styles here */
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f0f0f0;
                        color: #333333;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #ffffff;
                        border-radius: 8px;
                        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                    }
                    .logo {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .logo img {
                        max-width: 150px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='logo'>
                    </div>
                    <p>Hello {$this->firstname},</p>
                    <p>Good Day,</p>
                    <p>This is KPSM-Educational Assistance Program</p>
                    <p>Were sorry {$this->firstname}! Your educational assistance application has been rejected. Because of {$this->decline}.</p>
                    <p>Sorry for what happened, but still always check your email for the next educational assistance program that will be sent to your email, for you to have a chance to receive educational assistance.</p>
                    <p>Thank you!</p>
                    <p>KPSM</p>
                </div>
            </body>
        </html>
    ";
        return $this->subject('KPSM-Educational Assistance')
            ->html($message);
    }
}
