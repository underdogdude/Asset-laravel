<?php

use App\AssetTable;
use App\LocationTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $asset = AssetTable::select('location')->distinct('location')->get();

        foreach ($asset as $row) {
            LocationTable::create([
                'name' => $row->location
            ]);
        }

        $location = LocationTable::all();
        foreach ($location as $row) {
            DB::table('asset_tables')->where('location',$row->name)->update(['location' => $row->id]);
        }
    }
}
