<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $acronym;
    public $subject;
    public $emailmessage;
    public $file;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $acronym, $subject, $emailmessage, $file = null)
    {
        $this->name = $name;
        $this->acronym = $acronym;
        $this->subject = $subject;
        $this->emailmessage = $emailmessage;
        $this->file = $file;
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
                    <p>Hello {$this->name},</p>
                    <p>Good Day,</p>
                    <p>This is Kongreso Para Sa Mamamayan (KPSM)</p>
                    <p>{$this->emailmessage}</p>";

        if ($this->file) {
            $message .= "<p>{$this->file}</p>";
        }

        $message .= "<p>Thank you!</p>
                    <p>KPSM</p>
                </div>
            </body>
        </html>
        ";

        return $this->subject($this->subject)
                    ->html($message);
    }
}
