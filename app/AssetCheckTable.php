<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetCheckTable extends Model
{
    protected $table = 'asset_check_tables';

    protected $fillable = [
        'assetId',
        'statusId',
        'userId'
    ];
}
