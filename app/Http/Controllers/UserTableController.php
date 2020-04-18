<?php

namespace App\Http\Controllers;

use App\User;
use App\UserAppTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserTableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('user.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $user = new UserAppTable();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->password = $request->password;
        $user->save();

        return 'success';
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$id},id",
        ]);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        if ($request->has('reset')) {
            DB::table('user_app_tables')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'status' => $request->status,
                    'password' => '123456',
                    'updated_at' => now()
                ]);
        }else{
            DB::table('user_app_tables')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'status' => $request->status,
                    'updated_at' => now()
                ]);
        }
        return 'success';
    }

    public function destroy($id)
    {
        DB::table('user_app_tables')->where('id', '=', $id)->delete();
        return 'success';
    }
}
