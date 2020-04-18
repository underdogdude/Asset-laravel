<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusTable extends Model
{
    protected $table = 'status_tables';

    protected $fillable = [
        'name'
    ];
}
