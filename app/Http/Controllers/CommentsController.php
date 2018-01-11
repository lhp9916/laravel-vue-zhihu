<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    protected $answer;
    protected $question;
    protected $comment;

    /**
     * CommentsController constructor.
     * @param $answer
     * @param $question
     * @param $comment
     */
    public function __construct(AnswerRepository $answer, QuestionRepository $question, CommentRepository $comment)
    {
        $this->answer = $answer;
        $this->question = $question;
        $this->comment = $comment;
    }

    public function answer($id)
    {
        return $this->answer->getAnswerCommentsById($id);
    }

    public function question($id)
    {
        return $this->question->getQuestionCommentById($id);
    }

    public function store()
    {
        $model = $this->getModelNameType(request('type'));

        $comment = $this->comment->create([
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
