<?php

namespace App\Repositories;

use App\Answer;

class AnswerRepository
{
    public function create(array $data)
    {
        return Answer::create($data);
    }

    public function byId($id)
    {
        return Answer::find($id);
    }
}