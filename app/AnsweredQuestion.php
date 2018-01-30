<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Foundation\Auth\User as Authenticatable;

class AnsweredQuestion extends Model
{
    use Notifiable;

    protected $primaryKey = 'answer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'answer_id', 'answered_question', 'user_answer', 'answer_score', 'up_votes', 'down_votes', 'answered', 'email_address'
    ];

    public function votes() {
      return $this->hasMany('App\Vote');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token',
    ]; */
}
