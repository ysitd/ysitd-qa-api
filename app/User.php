<?php

namespace YSITD;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['telegram_id'];
    
    public $timestamps = false;
}
