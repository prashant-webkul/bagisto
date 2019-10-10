<?php


namespace Webkul\Custom\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsNotification extends Mailable
{
    use Queueable, SerializesModels;

    /*
     * @var data
     * */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->to(\Company::getCurrent()->getDetails->email, \Company::getCurrent()->getDetails->first_name)
            ->from(env('SHOP_MAIL_FROM'))
            ->subject(trans('Contact Us Response'))
            ->view('custom::emails.contact-us');
    }
}