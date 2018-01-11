<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Comment;
use App\Question;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function answer($id)
    {
        $comments = Answer::with('comments', 'comments.user')->where('id', $id)->first();
        return $comments;
    }

    public function question($id)
    {
        $comments = Question::with('comments', 'comments.user')->where('id', $id)->first();
        return $comments;
    }

    public function store()
    {
        $model = $this->getModelNameType(request('type'));
        $comment = Comment::create([
            'commentable_id'   => request('model'),
            'commentable_type' => $model,
            'user_id'          => \Auth::guard('api')->user()->id,
            'body'             => request('body'),
        ]);
        return $comment;
    }

    private function getModelNameType($type)
    {
        return $type === 'question' ? 'App\Question' : 'App\Answer';
    }

}
