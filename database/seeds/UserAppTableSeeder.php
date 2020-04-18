<?php

use App\AssetTable;
use App\UserAppTable;
use Illuminate\Database\Seeder;

class UserAppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $asset = AssetTable::select('user_manage')->distinct('user_manage')->get();

        foreach ($asset as $row) {
            UserAppTable::create([
                'name' => $row->user_manage
            ]);
        }

        $usrApp = UserAppTable::all();
        foreach ($usrApp as $row) {
            DB::table('asset_tables')->where('user_manage',$row->name)->update(['user_manage' => $row->id]);
        }
    }
}
