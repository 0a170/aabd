<?php

namespace App;

use App\Notifications\VerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email', 'password', 'profile_image', 'description',
        'questions_answered', 'score', 'verified', 'email_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    *Send user verification email
    *
    *@return void
    */
    public function sendVerificationEmail() {
      $this->notify(new VerifyEmail($this));
    }


    public function answeredQuestions() {
      return $this->hasMany('App\AnsweredQuestion');
    }

    public function comments() {
       return $this->hasMany('App\Comment');
    }

}
