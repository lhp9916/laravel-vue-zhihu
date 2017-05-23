<?php

namespace App\Mailer;

use Naux\Mail\SendCloudTemplate;
use Mail;

class Mailer
{
    /**
     * @param $template
     * @param $email
     * @param array $data
     */
    protected function sendTo($template, $email, array $data)
    {
        $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use ($email) {
            $message->from('lhp9916@gmail.com', 'lhp');
            $message->to($email);
        });
    }
}