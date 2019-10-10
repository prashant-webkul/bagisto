<?php

namespace Webkul\Custom\Http\Controllers;

use Webkul\Custom\Http\Controllers\Controller;
use Webkul\Custom\Mails\ContactUsNotification;

/**
 * Custom controller
 */
 class CustomController extends Controller
{
    public function sendContactEmail()
    {
        $status = false;

        $data = request()->except('_token');

        try {
            \Mail::queue(new ContactUsNotification($data));

            $status = true;

            session()->flash('success', 'Your response have been successfully submitted');
        } catch (\Exception $e) {
            session()->flash('warning', 'Your response cannot be submitted');
        }

        return redirect()->route('custom.contact-us.response', ['data' => $status]);
    }

    public function contactUsResponse($data)
    {
        return view('custom::response-status')->with('data', $data);
    }
}