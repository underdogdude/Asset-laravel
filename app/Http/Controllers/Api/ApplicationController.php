<?php

namespace App\Http\Controllers\Api;

use App\AssetCheckTable;
use App\AssetTable;
use App\Http\Controllers\AssetCheckController;
use App\LocationTable;
use App\RoomTable;
use App\UserAppTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    function login(Request $request)
    {
        $result = null;
        $message = 'Validator error';
        $status = 500;
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $result = $validator->errors();
        } else {
            $user = UserAppTable::where('email', $request->email)->where('password', $request->password)->first();
            if ($user) {
                if ($user->status == 1) {
                    $result = $user;
                    $status = 200;
                    $message = 'Login Success';
                } else {
                    $result = $user;
                    $status = 201;
                    $message = 'This Account Has Been Suspended';
                }
            } else {
                $result = $user;
                $status = 403;
                $message = 'Access denied';
            }
        }

        $response = [
            'status' => $status,
            'message' => $message,
            'result' => $result
        ];

        return response()->json($response);
    }

    function addCheckAsset(Request $request)
    {
        $result = null;
        $message = 'Validator error';
        $status = 500;
        $validator = Validator::make($request->all(), [
            'assetId' => 'required|numeric',
            'statusId' => 'required|numeric',
            'userId' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $result = $validator->errors();
        } else {
            $asset = AssetTable::where('id', $request->assetId)->where('user_manage',$request->userId)->first();
            if ($asset) {
                $result = AssetCheckTable::create($request->all());
                $status = 200;
                $message = 'success';
            } else {
                $status = 403;
                $message = 'Access denied';
            }
        }

        $response = [
            'status' => $status,
            'message' => $message,
            'result' => $result
        ];

        return response()->json($response);
    }

    function getLocation()
    {
        $result = [];
        $location = LocationTable::all();
        foreach ($location as $row) {
            $temp = [
                'location' => $row,
                'room' => RoomTable::where('location',$row->id)->get()
            ];
            array_push($result, $temp);
        }
        return $result;
    }

    function getAsset(Request $request)
    {
        $result = null;
        $message = 'Not found';
        $status = 404;
        $asset = DB::table('asset_tables')
            ->join('user_app_tables', 'asset_tables.user_manage', '=', 'user_app_tables.id')
            ->join('location_tables', 'asset_tables.location', '=', 'location_tables.id')
            ->join('room_tables', 'asset_tables.room', '=', 'room_tables.id')
            ->select('asset_tables.*', 'user_app_tables.name as user_manage_name','location_tables.name as location','room_tables.name as room')
            ->where('inv_number', $request->code)->orWhere('erp_number',$request->code)
            ->first();
        if ($asset) {
            $result = $asset;
            $status = 200;
            $message = 'success';
        }

        $response = [
            'status' => $status,
            'message' => $message,
            'result' => $result
        ];

        return response()->json($response);
    }

    function getAssetList(Request $request)
    {
        $data = DB::table('asset_tables')
            ->join('user_app_tables', 'asset_tables.user_manage', '=', 'user_app_tables.id')
            ->join('location_tables', 'asset_tables.location', '=', 'location_tables.id')
            ->join('room_tables', 'asset_tables.room', '=', 'room_tables.id')
            ->select('asset_tables.*', 'user_app_tables.name as user_manage_name','location_tables.name as location','room_tables.name as room')
            ->where('asset_tables.user_manage','=',$request->id)
            ->get();

        $response = [
            'status' => 200,
            'message' => 'size : '.count($data),
            'result' => $data
        ];

        return $response;
    }

}
