<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use Notifiable;
    
    protected $primaryKey = 'vote_id';
    
    
    
    protected $fillable = [
        'vote_id', 'answer_id', 'answer', 'up_votes', 'down_votes', 'ip_address'
    ];
    
    
}
