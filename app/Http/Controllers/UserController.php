<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
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

    public function fetchAuth()
    {
        $user = User::select()
            ->where('company_id', Auth::user()->company_id)
            ->where('id', Auth::user()->id)
            ->with('company', 'roles')
            ->first();
        $user->image = url($user->image);
        $user->company->logo = url($user->company->logo);
        return $this->respondWithSuccess('successfully fetch authenticated user', $user);
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




            $user = User::find($request->user_id);
            $user->name = $request->user_name;
            $user->email = $request->user_email;


            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $destinationPath = public_path('images/user');
                $fileExtension = $file->getClientOriginalExtension();  // Get the file extension
                $fileName = uniqid() . '.' . $fileExtension;
                $file->move($destinationPath, $fileName);
                $image_path = 'images/user/' . $fileName;
                $user->image = $image_path;
            }


            $user->save();

            $user->removeRole($user->roles[0]->name);  // Remove the current roles
            $user->assignRole($request->user_role);


            $company = Company::find($user->company_id);
            $company->name = $request->company_name;


            $company->email = $request->company_email;
            $company->phone = $request->company_phone;
            $company->address = $request->company_address;
            $company->other_info = $request->company_other_info;

            if ($request->hasFile('company_logo')) {
                $file = $request->file('company_logo');
                $destinationPath = public_path('images/company');
                $fileExtension = $file->getClientOriginalExtension();  // Get the file extension
                $fileName = uniqid() . '.' . $fileExtension;
                $file->move($destinationPath, $fileName);
                $logoPath = 'images/company/' . $fileName;
                $company->logo = $logoPath;
            }
            $company->save();
            Session::flash('success', 'User profile successfully updated!');
            return redirect()->back();

        } catch (\Throwable $th) {
            return $this->respondWithError('error', $th->getMessage());
        }
    }
}
