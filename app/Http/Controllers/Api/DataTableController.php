<?php

namespace App\Http\Controllers\Api;

use App\AssetCheckTable;
use App\AssetTable;
use App\UserAppTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class DataTableController extends Controller
{
    public function userServerSide()
    {
        $data = UserAppTable::all();
        return Datatables::of($data)->make();
    }

    public function assetServerSide()
    {
        $data = AssetTable::all();
        return Datatables::of($data)->make();
    }

    public function assetSearchServerSide(Request $request)
    {
        $data = AssetTable::all();
        // if($request->user != "") {

        //     $temp = [];
        //     foreach ($data as $list) {
        //         if ($list->user_manage == $request->user) {
        //             array_push($temp, $list);
        //         }
        //     }
        //     $data = $temp;
        // }
        // return Datatables::of($data)->make();

        $result = $data;
      
        if ($request->room != 'all') {
            $temp = [];
            foreach ($result as $list) {
                if ($list->room == $request->room) {
                    array_push($temp, $list);
                }
            }
            $result = $temp;
        }

        if ($request->user != 'all') {
            $temp = [];
            foreach ($result as $list) {
                if ($list->user_manage == $request->user) {
                    array_push($temp, $list);
                }
            }
            $result = $temp;
        }
        return Datatables::of($result)->make();
    }

    public function assetCountServerSide(Request $request)
    {

        $data = DB::select( DB::raw("select s.id as status,DATE_FORMAT(a.created_at,'%Y-%m-%d') as lastdate,aa.*
from asset_check_tables a
inner join (
    select assetId, max(created_at) as latest
    from asset_check_tables
    group by assetId
) l
on a.created_at = l.latest and a.assetId = l.assetId
INNER JOIN status_tables s ON s.id = a.statusId
INNER JOIN asset_tables aa ON aa.id = a.assetId
where DATE_FORMAT(a.created_at,'%Y-%m-%d') >= '$request->date_start' and DATE_FORMAT(a.created_at,'%Y-%m-%d') <= '$request->date_end'
order by a.assetId asc") );

        $result = $data;
        if ($request->location != 'all') {
            $temp = [];
            foreach ($data as $list) {
                if ($list->location == $request->location) {
                    array_push($temp, $list);
                }
            }
            $result = $temp;
        }

        if ($request->room != 'all') {
            $temp = [];
            foreach ($result as $list) {
                if ($list->room == $request->room) {
                    array_push($temp, $list);
                }
            }
            $result = $temp;
        }

        if ($request->user != 'all') {
            $temp = [];
            foreach ($result as $list) {
                if ($list->user_manage == $request->user) {
                    array_push($temp, $list);
                }
            }
            $result = $temp;
        }
        return Datatables::of($result)->make();
    }
}
