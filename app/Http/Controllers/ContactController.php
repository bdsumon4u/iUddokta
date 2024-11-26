<?php

namespace App\Http\Controllers;

use App\Events\SendingContactEmail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);
        event(new SendingContactEmail($data));

        return redirect()->back()->with('success', 'Email is Sending..');
    }
}
