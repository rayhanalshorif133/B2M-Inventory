<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;


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

    public function fetchAuth()
    {
        $data = User::select()
            ->where('company_id', Auth::user()->company_id)
            ->where('id', Auth::user()->id)
            ->with('company', 'roles')
            ->first();
        return $this->respondWithSuccess('successfully fetch authenticated user', $data);
    }

    public function fetchRoles()
    {
        $roles = Role::select('id', 'name')->orderBy('id', 'asc')->get();
        return $this->respondWithSuccess('successfully fetch all user roles', $roles);
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
            $user->image = $this->storeImage($request['image']);
            $user->save();
            $user->assignRole($request['role']);


            return $this->respondWithSuccess('success', 'Successfully created user');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', 'Something went wrong');
        }
    }


    public function fetchSidebarData()
    {
        $auth_user_data = [
            'name' => Auth::user()->name,
            'image' => Auth::user()->image,
            'company' => Auth::user()->company,
            'count_of_users' => User::count()
        ];
        return $this->respondWithSuccess('Successfully fetched sidebar data', $auth_user_data);
    }

    public function profile(Request $request)
    {
        if ($request->method() == 'GET') {
            $roles = Role::select('id', 'name')->orderBy('id', 'asc')->get();
            $user = User::select()
                ->where('company_id', Auth::user()->company_id)
                ->where('id', Auth::user()->id)
                ->with('company', 'roles')
                ->first();
            return view('user.profile', compact('user', 'roles'));
        }

        try {


            $user = User::find(Auth::user()->id);
            $user->name = $request->user_name;
            $user->email = $request->user_email;
            if ($request->user_image) {
                $user->image = $this->storeImage($request->user_image);
            }
            $user->save();


            $company = Company::find($user->company_id);
            $company->name = $request->company['name'];
            if ($request->company['logo']) {
                $company->logo = $this->storeImage($request->company['logo']);
            }
            $company->email = $request->company['email'];
            $company->phone = $request->company['phone'];
            $company->address = $request->company['address'];
            $company->other_info = $request->company['other_info'];
            $company->save();

            return $this->respondWithSuccess('success', 'Profile update Successful');
        } catch (\Throwable $th) {
            return $this->respondWithError('error', $th->getMessage());
        }
    }
}
