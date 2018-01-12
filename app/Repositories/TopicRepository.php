<?php

namespace App\Repositories;


use Request;
use App\Topic;

class TopicRepository
{
    public function getTopicForTagging(Request $request)
    {
        return Topic::select(['id', 'name'])
            ->where('name', 'like', '%' . $request->query('q') . '%')
            ->get();
    }
}