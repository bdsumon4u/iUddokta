<?php

namespace App\Listeners;

use App\Mail\ContactMail;
use App\Repository\SettingsRepository;
use Illuminate\Support\Facades\Mail;

class SendContactEmail
{
    protected $settingsRepo;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SettingsRepository $settingsRepo)
    {
        $this->settingsRepo = $settingsRepo;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
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
