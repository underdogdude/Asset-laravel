<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ImageUploadController extends Controller
{
    function index()
    {
        return view('image_upload');
    }

    function upload(Request $request)
    {
        if($request->image == '') {

            DB::table('asset_tables')->where('id',$request->id)->update(['image' => null]);
            return 'success';
        }

        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        $imageName = time().'_'.'id_'.request()->id.'.'.request()->image->getClientOriginalExtension();
        $imagePath = '/images/uploads/'.$imageName;
        request()->image->move(public_path('images/uploads'), $imageName);

        DB::table('asset_tables')->where('id',$request->id)->update(['image' => $imagePath]);
        return response()->json([
            'path' => $imagePath
        ]);
    }
}
?>
