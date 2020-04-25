<?php
namespace App\Http\Controllers;

use App\AssetTable;
use App\Imports\AssetImportExcel;
use Illuminate\Http\Request;
use DB;
use Excel;
use App\UserAppTable;
use App\LocationTable;
use App\RoomTable;

class ImportExcelController extends Controller{

    function index() { 
        $data = DB::table('asset_tables')->orderBy('id','DESC')->get();
        return view('asset_tables', compact('data'));
    }

    function import(Request $request) { 

        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try
        {
            $row_excel = Excel::toArray(new AssetImportExcel(), request()->file('file'));
            $start_index;
            // set array follow by format
            if(!empty($row_excel))
            {   
                $count = count($row_excel[0]) ;
                for($i = 0; $i <= $count; $i++) {
                    // your code here using $i as the position 
                    if(intval($row_excel[0][$i][0]) == 1) { 
                        $start_index = $i;
                        break;
                    }
                }
            }

            $row_excel = array_slice($row_excel[0], intval($start_index), count($row_excel[0]));

            if(!empty($row_excel))
            {   
                foreach($row_excel as $row)
                {
                    
                        if($row[1] != null && $row[2] != null  ) {
    
                            AssetTable::create([
                                'inv_number' => trim($row[1]),
                                'erp_number' => trim($row[2]),
                                'description1' => trim($row[3]),
                                'description2' => trim($row[4]),
                                'code' => trim($row[5]),
                                'price' => trim($row[6]),
                                'location' => trim($row[7]),
                                'room' => trim($row[8]),
                                'year' => trim($row[9]),
                                'user_manage' => trim($row[10])
                            ]);
    
                            if(UserAppTable::where('name', '=', trim($row[10]))->doesntExist())
                            {
                                // Create New
                                UserAppTable::create([
                                    'name' => trim($row[10])
                                ]);
                            }
    
                            if(LocationTable::where('name', '=', trim($row[7]))->doesntExist())
                            {
                                // update
                                LocationTable::create([
                                    'name' => trim($row[7])
                                ]);
                            }
    
                            if(RoomTable::where('name', '=', trim($row[8]))->doesntExist())
                            {
                                // update
                                RoomTable::create([
                                    'name' => trim($row[8]),
                                    'location' => trim($row[7])
                                ]);
                            }
                        }
                }
            }

            // update
            $usrApp = UserAppTable::all();
            foreach ($usrApp as $row) {
                DB::table('asset_tables')->where('user_manage',$row->name)->update(['user_manage' => $row->id]);
            }
            
            $roomLists = RoomTable::all();
            foreach ($roomLists as $row) {
                DB::table('asset_tables')->where('room',$row->name)->update(['room' => $row->id]);
            }
    
            $locationLists = LocationTable::all();
            foreach ($locationLists as $row) {
                DB::table('asset_tables')->where('location',$row->name)->update(['location' => $row->id]);
                DB::table('room_tables')->where('location',$row->name)->update(['location' => $row->id]);
            }

            return 'success';
        }
        catch (Exception $e) 
        {
            return 'error';
        }
    }
}