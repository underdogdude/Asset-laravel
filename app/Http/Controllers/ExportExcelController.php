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
}
