<?php

namespace App\Listeners;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class SendContactEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(protected \App\Repository\SettingsRepository $settingsRepo) {}

    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle($event): void
    {
        $data = $event->data;
        $email = optional($this->settingsRepo->first('company')->value)->email;
        // Mail::send(new ContactMail($data), compact('data'), function($message) use ($data, $email) {
        //     $message->from($data['email']);
        //     $message->to($email);
        //     $message->subject($data['subject']);
        // });
        Mail::to($email)->send(new ContactMail($data));
    }
}
