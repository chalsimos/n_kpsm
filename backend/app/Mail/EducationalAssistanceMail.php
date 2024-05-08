<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EducationalAssistanceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $codeGenerated;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstname, $codeGenerated, $url)
    {
        $this->firstname = $firstname;
        $this->codeGenerated = $codeGenerated;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
{
    $url = url('kpsm.png');

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
                        <img src='" . $url . "' alt='KPSM Logo'>
                    </div>
                    <p>Hello {$this->firstname},</p>
                    <p>This is KPSM-Educational Assistance. Here is your code: <strong>{$this->codeGenerated}</strong>. You can use this to track the update in your application. Just go to this website <a href='{$this->url}'>{$this->url}</a> and put your code to check the status.</p>
                    <p>And always check your email for the updates.</p>
                </div>
            </body>
        </html>
    ";

    return $this->subject('KPSM-Educational Assistance')
                ->html($message);
}

}
