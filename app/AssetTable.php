<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetTable extends Model
{
    protected $table = 'asset_tables';

    protected $fillable = [
        'inv_number',
        'erp_number',
        'description1',
        'description2',
        'code',
        'price',
        'location',
        'room',
        'year',
        'user_manage',
    ];
}
