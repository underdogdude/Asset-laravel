<?php

use App\AssetTable;
use App\LocationTable;
use App\RoomTable;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $asset = AssetTable::select('room','location')->distinct('room')->get();

        foreach ($asset as $row) {
            RoomTable::create([
                'name' => $row->room,
                'location' => $row->location
            ]);
        }

        $room = RoomTable::all();
        foreach ($room as $row) {
            DB::table('asset_tables')->where('room',$row->name)->update(['room' => $row->id]);
        }
    }
}
