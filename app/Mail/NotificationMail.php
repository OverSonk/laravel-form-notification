<?php

namespace App\Mail;

use App\Models\Notification\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Notification $message, $file)
    {
        $this->message = $message;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = "Notificación para - " .$this->message->name;

        $fromInfo = [
            'address' => env("MAIL_FROM_MAILABLE", "example@example.com"), 
            'name' => $this->message->name
        ];

        $messageContent = [
            'name' => $this->message->name,
            'phone' => $this->message->phone,
            'email' => $this->message->email,
            'subject' => $this->message->subject,
            'contact' => env("MAIL_FROM_MAILABLE", "example@example.com")
        ];

         return $this->from($fromInfo)
                ->markdown('emails.notification')
                ->subject($this->message->subject)
                ->attach($this->file, [
                    'as' => $this->file->getClientOriginalName(),
                    'mime' => $this->file->getMimeType()
                ])
                ->with( $messageContent );
    }
}
