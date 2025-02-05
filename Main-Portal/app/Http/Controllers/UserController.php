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
            $roles = Role::select('id', 'name')->where('name', '!=', 'super-admin')->orderBy('id', 'asc')->get();
            return view('user.create', compact('roles'));
        }


        try {

            $has_email = User::select('id')->where('email', $request['email'])->where('company_id', Auth::user()->company_id)->first();

            if ($has_email) {
                Session::flash('error', 'Email already exists');
                return redirect()->back()->withInput();
            }


            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->company_id = Auth::user()->company_id;
            $user->password = Hash::make($request['password']);


            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $destinationPath = public_path('images/user');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = uniqid() . '.' . $fileExtension;
                $file->move($destinationPath, $fileName);
                $logoPath = 'images/user/' . $fileName;
                $user->image = $logoPath;
            }

            $user->save();

            // Assign the role to the user
            $user->assignRole($request['role']);

            Session::flash('success', 'Successfully created user');
            return redirect()->route('user.list');
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            // Session::flash('error', 'Something went wrong');
            return redirect()->back()->withInput();
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


        if($request->type == 'update-password') {

            if($request->password != $request->confirm_password){
                Session::flash('error', 'Password & confirm password doesn\'t match');
                return redirect()->back();  
            }

            $userID = $request->session()->get('loginId');
            $findUser = User::find($userID);
            $findUser->password = Hash::make($request->password);
            $findUser->save();
            Session::flash('success', 'Password successfully updated!');
            return redirect()->back();
        }

        if($request->type == 'update-email') {

            if(!$request->email){
                Session::flash('error', 'Please enter a valid email address');
                return redirect()->back();  
            }

            $userID = $request->session()->get('loginId');
            $hasEmail = User::select()->where('email',$request->email)->where('id', '!=', $userID)->first();
            if($hasEmail){
                Session::flash('error', 'Email already exists, please try another email');
                return redirect()->back();  
            }

            
            $findUser = User::find($userID);
            $findUser->email = $request->email;
            $findUser->save();
            $emailController = new EmailController();
            $emailController->sendEmailVarify();

            Session::flash('success', 'Check your email for a verification link.');
            return redirect()->back();
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
