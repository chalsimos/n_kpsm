<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EducationalAssistanceCustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $subject;
    public $emailmessage;

    /**
     * Create a new message instance.
     */
    public function __construct($firstname, $subject, $emailmessage)
    {
        $this->firstname = $firstname;
        $this->subject = $subject;
        $this->emailmessage = $emailmessage;
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
                    /* Inline CSS styles */
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
            <body style='font-family: Arial, sans-serif; background-color: #f0f0f0; color: #333333;'>
                <div class='container' style='max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
                    <div class='logo' style='text-align: center; margin-bottom: 20px;'>
                        <!-- Your logo here -->
                    </div>
                    <p>Hello {$this->firstname},</p>
                    <p>Good Day,</p>
                    <p>This is KPSM-Educational Assistance Program</p>
                    <p>{$this->emailmessage}</p>
                    <p>Thank you!</p>
                    <p>KPSM</p>
                </div>
            </body>
        </html>
    ";


        return $this->subject($this->subject)
            ->html($message);
    }
}
