<?php
/**
 * Created by PhpStorm.
 * User: lhp
 * Date: 2017/5/8
 * Time: 0:29
 */

namespace App\Repositories;


use App\Question;
use App\Topic;

/**
 * Class QuestionRepository
 * @package App\Repositories
 */
class QuestionRepository
{
    public function byId($id)
    {
        return Question::find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        return Question::where('id', $id)->with('topics','answers')->first();
    }

    public function create(array $data)
    {
        return Question::create($data);
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic) {
            if (is_numeric($topic)) {
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }
            $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

    public function getQuestionsFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }

    public function getQuestionCommentById($id)
    {
        return Question::with('comments', 'comments.user')->where('id', $id)->first();
    }
}