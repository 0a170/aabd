<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
    //
    
    protected $primaryKey = 'question_id';
    
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question', 'asker_email'
    ];
    
}
