<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\AssetCheckExportExcel;
use App\UserAppTable;
use App\LocationTable;
use App\RoomTable;
use DB;
use Excel;
use \Maatwebsite\Excel\Sheet;


class ExportExcelController extends Controller
{
    //
    function index() {
        
        $data = DB::table('asset_tables')->orderBy('id','DESC')->get();
        return view('asset_tables', compact('data'));
    }

    function export(Request $request) { 

        $param = $request->data;
        $date_start =  $request->date_start;
        $date_end =  $request->date_end;
        $array = [];
        

        if(!empty($param))
        {   

            $res_arr_values[] = ["AM-รายงานตรวจนับสินทรัพย์"];
            $res_arr_values[] = ["C1005000:ภาควิชาวิศวกรรมอุตสาหการ  คณะวิศวกรรมศาสตร์ มหาวิทยาลัยมหิดล"];
            $res_arr_values[] = ["ตรวจสอบพัสดุประจำปีงบประมาณตั้งแต่วันที่".$date_start." ถึง ".$date_end];
            $res_arr_values[] = [
                "No.", 
                "Inventory number", 
                "Asset", 
                "Asset description1", 
                "Asset description2", 
                "Code",
                " Curr.acq. Value",
                "Asset Location",
                "Room",
                "Year",
                "ชื่อผู้รับ",
                "สภาพของสินทรัพย์",
                null,
                null,
                null,
                "ลงชื่อ",
                "วันที่ตรวจ"
            ];
            $res_arr_values[] = [
                "ลำดับที่", 
                "รหัสครุภัณฑ์", 
                "รหัสครุภัณฑ์", 
                "รายการ", 
                "รายละเอียด", 
                "หมายเลขเครื่อง",
                "ราคา",
                "สถานที่",
                "ห้อง",
                null,
                "ผิดชอบ/ดูแล",
                "ใช้งานอยู่",
                "ชำรุด/",
                "ไม่จำเป็น",
                "หาไม่พบ",
                "ผู้ตรวจ",
                "สอบพัสดุ"
            ];
            $res_arr_values[] = [
                null, 
                null, 
                "ในระบบ", 
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                "เสื่อมสภาพ",
                "ใช้งาน",
                null,
                null,
                null
            ];
            $res_arr_values[] = [
                null, 
                null, 
                "MU-ERP", 
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null
            ];
            $res_arr_values[] = [
                null, 
                null, 
                null, 
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null
            ];


            $i = 1;
            foreach($param as $row) 
            {
                // Check status
                $status1 = null;
                $status2 = null;
                $status3 = null;
                $status4 = null;
                if(intval($row['status']) == 1) { 
                    $status1 = '✓';
                }else if(intval($row['status']) == 2) { 
                    $status2 = '✓';
                }else if(intval($row['status']) == 3) { 
                    $status3 = '✓';
                }else if(intval($row['status']) == 4) { 
                    $status4 = '✓';
                }

                // query user mange, roo, m loacrino
                $user = UserAppTable::select('name')->where('id', intval($row['user_manage']))->get()->first();
                $room = RoomTable::select('name')->where('id', intval($row['room']))->get()->first();
                $location = LocationTable::select('name')->where('id', intval($row['location']))->get()->first();

                $res_arr_values[] = array(
                    $i ,
                    $row['inv_number'],
                    $row['erp_number'] . " ",
                    $row['description1'],
                    $row['description2'],
                    $row['code'],
                    $row['price'],
                    $location['name'],
                    $room['name'],
                    $row['year'],
                    $user['name'],
                    $status1,
                    $status2,
                    $status3,
                    $status4,
                    null,
                    null
                );
                $i++;
            }
        }

        $export = new AssetCheckExportExcel($res_arr_values);
    
        return  Excel::download($export, 'sdfmlsdfm.xlsx');

    }


    function exportAll(Request $request) { 
    
        $param = $request->data_check;
        $data = DB::select( DB::raw("select DATE_FORMAT(a.created_at,'%Y-%m-%d') as lastdate,aa.*
        from asset_tables a
        inner join (
            select id, max(created_at) as latest
            from asset_tables
            group by id
        ) l
        on a.created_at = l.latest and a.id = l.id
        INNER JOIN asset_tables aa ON aa.id = a.id
        where DATE_FORMAT(a.created_at,'%Y-%m-%d') >= '$request->date_start' and DATE_FORMAT(a.created_at,'%Y-%m-%d') <= '$request->date_end'
        order by a.id asc") );
        
        $array = $data;

        if ($request->location != 'all') {
            $temp = [];
            foreach ($data as $list) {
                if ($list->location == $request->location) {
                    array_push($temp, $list);
                }
            }
            $array = $temp;
        }

        if ($request->room != 'all') {
            $temp = [];
            foreach ($array as $list) {
                if ($list->room == $request->room) {
                    array_push($temp, $list);
                }
            }
            $array = $temp;
        }

        if ($request->user != 'all') {
            $temp = [];
            foreach ($array as $list) {
                if ($list->user_manage == $request->user) {
                    array_push($temp, $list);
                }
            }
            $array = $temp;
        }

        // if(empty($array)) { 
        //     return;
        // }

        $res_arr_values[] = ["AM-รายงานตรวจนับสินทรัพย์"];
        $res_arr_values[] = ["C1005000:ภาควิชาวิศวกรรมอุตสาหการ  คณะวิศวกรรมศาสตร์ มหาวิทยาลัยมหิดล"];
        $res_arr_values[] = ["ตรวจสอบพัสดุประจำปีงบประมาณตั้งแต่วันที่".$request->date_start." ถึง ".$request->date_end];
        $res_arr_values[] = [
            "No.", 
            "Inventory number", 
            "Asset", 
            "Asset description1", 
            "Asset description2", 
            "Code",
            " Curr.acq. Value",
            "Asset Location",
            "Room",
            "Year",
            "ชื่อผู้รับ",
            "สภาพของสินทรัพย์",
            null,
            null,
            null,
            "ลงชื่อ",
            "วันที่ตรวจ"
        ];
        $res_arr_values[] = [
            "ลำดับที่", 
            "รหัสครุภัณฑ์", 
            "รหัสครุภัณฑ์", 
            "รายการ", 
            "รายละเอียด", 
            "หมายเลขเครื่อง",
            "ราคา",
            "สถานที่",
            "ห้อง",
            null,
            "ผิดชอบ/ดูแล",
            "ใช้งานอยู่",
            "ชำรุด/",
            "ไม่จำเป็น",
            "หาไม่พบ",
            "ผู้ตรวจ",
            "สอบพัสดุ"
        ];
        $res_arr_values[] = [
            null, 
            null, 
            "ในระบบ", 
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            "เสื่อมสภาพ",
            "ใช้งาน",
            null,
            null,
            null
        ];
        $res_arr_values[] = [
            null, 
            null, 
            "MU-ERP", 
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ];
        $res_arr_values[] = [
            null, 
            null, 
            null, 
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ];
        
        $i = 1;
        foreach($array as $item)
        {

            $status1 = null;
            $status2 = null;
            $status3 = null;
            $status4 = null;

            if(!empty($param)){
                foreach($param as $row) 
                {
                    // Check status
                    if( $item->inv_number == $row['inv_number'] ) { 
                        if(intval($row['status']) == 1) { 
                            $status1 = '✓';
                        }else if(intval($row['status']) == 2) { 
                            $status2 = '✓';
                        }else if(intval($row['status']) == 3) { 
                            $status3 = '✓';
                        }else if(intval($row['status']) == 4) { 
                            $status4 = '✓';
                        }
                    }
                }
            }
            

            // query user mange, room, location
            $user = UserAppTable::select('name')
                    ->where('id', intval($item->user_manage))
                    ->get()
                    ->first();
            $room = RoomTable::select('name')
                    ->where('id', intval($item->room))
                    ->get()
                    ->first();
            $location = LocationTable::select('name')
                    ->where('id', intval($item->location))
                    ->get()
                    ->first();

            $res_arr_values[] = array(
                $i ,
                $item->inv_number,
                $item->erp_number . " ",
                $item->description1,
                $item->description2,
                $item->code,
                $item->price,
                $location->name,
                $room->name,
                $item->year,
                $user->name,
                $status1,
                $status2,
                $status3,
                $status4,
                null,
                null
            );
            
            $i++;

        }

        $export = new AssetCheckExportExcel($res_arr_values);
        return  Excel::download($export, 'excel.xlsx');
    }
}
