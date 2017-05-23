<?php

namespace App\Repositories;

use App\Message;

class MessageRepository
{
    public function create(array $data)
    {
        return Message::create($data);
    }
}
