<?php

namespace YSITD;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';
    protected $fillable = ['user_id', 'question_id', 'result', 'answer'];
    
    public $timestamps = false;
}
