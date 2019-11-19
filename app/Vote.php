<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'note_id'];
    
    public function note()
    {
        return $this->belongsTo('App\Note');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
