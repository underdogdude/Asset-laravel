<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomTable extends Model
{
    protected $table = 'room_tables';

    protected $fillable = [
        'id',
        'name',
        'location'
    ];
}
