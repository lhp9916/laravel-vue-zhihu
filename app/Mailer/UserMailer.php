<?php

namespace App\Mailer;

use App\User;
use Auth;

class UserMailer extends Mailer
{
    public function followNotifyEmail($email)
    {
        $data = [
            'url' => 'http://zhihu.app',
            'name' => user('api')->name,
        ];

        $this->sendTo('new_follow', $email, $data);
    }

    public function passwordReset($email, $token)
    {
        $data = [
            'url' => url('password/reset', ['token' => $token]),
        ];
        $this->sendTo('zhihu_app_register', $email, $data);
    }

    public function welcome(User $user)
    {
        $data = [
            'url' => route('email.verify', ['token' => $user->confirmation_token]),
            'name' => $user->name,
        ];

        $this->sendTo('zhihu_app_register', $user->email, $data);
    }
}