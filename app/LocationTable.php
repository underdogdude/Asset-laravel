<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationTable extends Model
{
    protected $table = 'location_tables';

    protected $fillable = [
        'id',
        'name'
    ];
}
