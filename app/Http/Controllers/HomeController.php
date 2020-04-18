<?php

namespace App\Http\Controllers;

use App\AssetTable;
use App\Imports\AssetImport;
use App\UserAppTable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.index');
    }

    public function import()
    {
        Excel::import(new AssetImport(), public_path('file/asset.xlsx'));

        return 'success';
    }

    public function user_manage()
    {
        $asset = AssetTable::select('user_manage')->distinct('user_manage')->get();

        foreach ($asset as $row) {
            UserAppTable::create([
                'name' => $row->user_manage,
            ]);
        }
        return response()->json($asset);
    }
}
