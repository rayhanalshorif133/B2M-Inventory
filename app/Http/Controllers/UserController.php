<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{

    public function list(Request $request)
    {

        if (request()->ajax()) {
            $query = User::where('company_id', Auth::user()->company_id)->orderBy('created_at', 'desc')->get();
            return DataTables::of($query)->toJson();
        }
        return view('user.list');
    }

    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('user.create');
        }


        try {

            $has_email = User::select('id')->where('email', $request['email'])->where('company_id', Auth::user()->company_id)->first();

            if ($has_email) {
                return $this->respondWithError('error', 'Email already exists');
            }


            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->company_id = Auth::user()->company_id;
            $user->password = Hash::make($request['password']);
            $img = $request['image'];

            if($request['image_type'] == '.jpg'){
                $img = str_replace('data:image/jpeg;base64,', '', $img);
            }else{
                $img = str_replace('data:image/png;base64,', '', $img);
            }

            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file_name = 'images/user/' . uniqid() . $request['image_type'];
            Storage::disk('public')->put($file_name, $data);
            $user->image = '/storage/' . $file_name;
            $user->save();
            $user->assignRole($request['role']);


            return $this->respondWithSuccess('success', 'Successfully created user');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', $th->getMessage());
            // return $this->respondWithError('error', 'Something went wrong');
        }
    }
}
