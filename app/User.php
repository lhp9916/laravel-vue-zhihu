<?php

namespace App;

use App\Mailer\UserMailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;
use Naux\Mail\SendCloudTemplate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirmation_token', 'avatar', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function follows()
    {
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }

    public function followThis($question)
    {
        //toggle 存在删除，不存在创建一条
        return $this->follows()->toggle($question);
    }

    //用户是否关注过该问题
    public function followed($question)
    {
        return !!$this->follows()->where('question_id', $question)->count();
    }

    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')->withTimestamps();
    }

    public function followersUser()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'follower_id')->withTimestamps();
    }

    //关注用户
    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }


    public function sendPasswordResetNotification($token)
    {
        (new UserMailer())->passwordReset($this->email, $token);
    }

    public function votes()
    {
        return $this->belongsToMany(Answer::class, 'votes')->withTimestamps();
    }

    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }

    /**
     * @param $answer  answer_id
     * @return bool
     */
    public function hasVotedFor($answer)
    {
        return !!$this->votes()->where('answer_id', $answer)->count();
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'to_user_id');
    }
}
