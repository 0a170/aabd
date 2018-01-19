<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //

    protected $primaryKey = 'comment_id';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'u_id', 'comment', 'commenter', 'commenter_icon', 'u_votes', 'd_votes'
    ];

}
