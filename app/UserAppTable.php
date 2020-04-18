<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAppTable extends Model
{
    protected $table = 'user_app_tables';

    protected $fillable = [
        'id','name', 'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];
}
