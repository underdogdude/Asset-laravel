<?php

namespace App\Http\Controllers;

use App\AssetTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('asset.index');
    }

    public function create()
    {
        return view('asset.create');
    }

    public function store(Request $request)
    {
        $lastId = AssetTable::create($request->all())->id;
        // return 'success';
        return response()->json(array('success' => true, 'last_insert_id' => $lastId ), 200);

    }

    public function show($id)
    {
        $data = DB::table('asset_tables')
            ->join('user_app_tables', 'asset_tables.user_manage', '=', 'user_app_tables.id')
            ->join('location_tables', 'asset_tables.location', '=', 'location_tables.id')
            ->join('room_tables', 'asset_tables.room', '=', 'room_tables.id')
            ->select('asset_tables.*', 'user_app_tables.name as user_manage_name','location_tables.name as location','room_tables.name as room')
            ->where('asset_tables.id','=',$id)
            ->first();
        if ($data != null) {
            return response()->json($data);
        } else {
            return [];
        }
    }

    public function edit($id)
    {
        return view('asset.edit', [
            'data' => AssetTable::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::table('asset_tables')->where('id',$id)->update($request->except('_token','_method'));
        return 'success';
    }

    public function destroy($id)
    {
        //
        // bright did
          // bright idd
            $data = DB::table('asset_check_tables')->where('assetId','=',$id)
                    ->first();

            if(is_null($data)) { 
                DB::table('asset_tables')->where('id', '=', $id)->delete();
                return 'success';
            }else{
                return 'NoDelete';
            }
            
        
    }
}
