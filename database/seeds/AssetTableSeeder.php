<?php

use App\Imports\AssetImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class AssetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new AssetImport(), public_path('file/asset.xlsx'));
    }
}
