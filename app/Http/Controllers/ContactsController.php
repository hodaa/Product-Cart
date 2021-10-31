<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;

class ContactsController extends Controller
{
    public function showContactForm()
    {
        return view('contact');
    }

    public function contact(ContactFormRequest $request)
    {
        // send contact details to email address

        return back()->with("status", "Your message has been received, We'll get back to you shortly.");
    }
}
