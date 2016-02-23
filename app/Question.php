<?php

namespace YSITD;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    protected $fillable = ['author', 'class', 'question', 'opt_a', 'opt_b', 'opt_c', 'opt_d', 'answer'];
    
    public $timestamps = false;
}
