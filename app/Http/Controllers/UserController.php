<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Auth, Mail, Session;
use App\Mail\UserMail;

class UserController extends Controller
{
    function __construct()
    {
        // set permission
        $this->middleware('permission:read-user', ['only' => ['index','show']]);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:update-user', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('admin.users.index', [
            'active' => 'user',
            'users' => User::whereHas('userseroles', function($query){
                $query->whereHas('role', function($q){
                    $q->where('slug', 'user');
                });
            })
            ->latest()->get(),
            'roles' => Role::where('slug', 'user')
            ->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.table', [
            'users' => User::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'role_id' => 'required',
            // 'phone' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->email;
        // $user->mobile = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        $role = Role::where('id', $request->role_id)->first();
        $user->roles()->attach($role);
		$user->permissions()->attach($role->permissions);

        return response()->json([
            'status' => 1, 
            'message' => "Success.! User has been added successfully.",            
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::where('slug', 'user')
            ->latest()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'role_id' => 'required',
            'password' => 'nullable|min:8',
            // 'phone' => 'required',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $this->userID();
        // $user->mobile = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->userseroles()->delete();
        $role = Role::where('id', $request->role_id)->first();
        $user->roles()->attach($role);

        $user->usersepermissions()->delete();
		$user->permissions()->attach($role->permissions);

        return response()->json([
            'status' => 1, 
            'message' => "Success.! User has been updated successfully.",            
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => 1, 
            'message' => "Success.! User has been deleted successfully.",            
        ], 200);
    }

    public function changePassword(){
        return view('admin.change-password', [
            'active' => 'change-password',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required || min:8 || different:old_password',
            'confirm_password' => 'required || same:new_password',
        ]);

        $user = Auth::user();
        if(!Hash::check($request->old_password, $user->password))
        {
            return response()->json([
                'status' => 0,
                'message' => 'Old password must be match.',
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json([
            'status' => 1,
            'message' => 'Password updated successfully.',
        ], 200);
    }

    public function forgetPassword(Request $request)
    {
        $request->validate(['email' => 'required']);

        if(!User::where('email', $request->email)->exists())
        {
            return back()->with('error', 'We could not find your account with '.$request->email.' email.');
        }
        
        $password = rand(100000, 99999999);
        $user = User::where('email', $request->email)->get()->first();
        $user->password = Hash::make($password);

        $mailData = [ 'name' =>  $user->name,'password' => $password,'template' => 'mail.email','subject' => 'New Password'];
        Mail::to($request->email)->send(new UserMail($mailData));
        $user->save();
        return back()->with('success', 'New password has been send to your registered '.substr($user->email, 0, 10). "***** email or ******".substr($user->mobile, -4)." Mobile Number");
    }


    // Create User Registertion
    public function registeruser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => 'required',
            'mobile' => 'required|digits:10|unique:users',
        ]);
        
        if(Session::has('user_register_otp') && isset($request->otp))
        {
            if(Session::get('user_register_otp') == $request->otp)
            {
                $user = new User();
                $user->name = $request->name;
                $user->address = $request->address;
                $user->mobile = $request->mobile;
                $user->email = $request->email;
                $user->password =Hash::make($request->password);
                $user->save();

                $role = Role::where('slug', 'user')->first();
                $user->roles()->attach($role);
                $user->permissions()->attach($role->permissions);

                Auth::loginUsingId($user->id);
                return response()->json(['status' => 1, 'message' => 'User registered successfully.', 'type' => 1]);
            }
            else
            {
                return response()->json(['status' => 0, 'message' => 'Invalid OTP.', 'type' => 1]);
            }
        }


        $otp = rand(100000, 999999);
        $mailData = [ 'name' => $request->name,'otp' => $otp,'template' => 'mail.otp','subject' => 'One Time Password'];
        Mail::to($request->email)->send(new UserMail($mailData));
        Session::put('user_register_otp', $otp);
        return response()->json(['status' => 1, 'message' => 'OTP has been sent In your '.substr($request->email, 0, 10).'****. if  you missed  please check spam folder.', 'type' => 0]);

        
    }


    // /////////////////////////////////////////////////
    public function staffIndex()
    {
        return view('admin.users.index', [
            'active' => 'user',
            'users' => User::whereHas('userseroles', function($query){
                $query->whereHas('role', function($q){
                    $q->where('slug', 'user');
                });
            })
            ->latest()->get(),
            'roles' => Role::where('slug', 'user')
            ->latest()->get(),
        ]);
    }
    

    public function loadTable()
    {
        return view('admin.users.table', [
            'users' => User::whereHas('userseroles', function($query){
                $query->whereHas('role', function($q){
                    $q->where('slug', 'user');
                });
            })
            ->latest()
            ->get(),
            'roles' => Role::where('slug', '!=', 'superadmin')
            ->where('slug', '!=', 'user')
            ->latest()->get(),
        ]);
    }

    public function staffCreate()
    {
        
    }

    public function staffStore(Request $request)
    {
        
    }

    public function staffEdit($id)
    {
        
    }

    public function staffUpdate(Request $request, $id)
    {
        
    }

    public function staffDestroy($id)
    {
        
    }

    public function UserChangeStatus($id)
    {
        $user = User::where('id', $id)->first();
        if($user)
        {
            if($user->status == 1)
            {
                $user->status = 0;
            }
            else
            {
                $user->status = 1;
            }
            $user->save();
        }

        return response()->json([
            'status' => 1,
            'message' => 'Success.! User status has been changed.',
        ], 200);
    }

    public function staffLoadTable()
    {
        return view('admin.staffs.table', [
            'staffs' => User::whereHas('userseroles', function($query){
                $query->whereHas('role', function($q){
                    $q->where('slug', '!=', 'superadmin')
                    ->where('slug', '!=', 'user');
                });
            })
            ->latest()
            ->get(),
            'roles' => Role::where('slug', '!=', 'superadmin')
            ->where('slug', '!=', 'user')
            ->latest()->get(),
        ]);
    }
    

    public function application($id){
        return view('admin.userapplications.index',[
            'applications' => Userapplication::where('user_id',$id)->get(),
            'active' => 'application',
            'staffs' => Staff::get(),
        ]);
    }


    public function userID()
    {
        $prefix = "HHNS";
        $date = date('my');
        $id = $prefix.$date.mt_rand();

        return $id;
    }

    public function sendUserStatusMail($id){
        $user = User::where('id',$id)->latest()->first();
        if ($user) {
            $mailData = ['name' => $user->name, 'template' => 'mail.status-email','subject' => 'Complete Password'];
            Mail::to($user->email)->send(new UserMail($mailData));
            return response()->json([
                'status' => 1,
                'message' => 'Mail succesfully send',
            ], 200);
        }
    }

    public  function loginuser(Request $request){
        $request->validate([
            'password' => 'required',
            'email' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (isset($user)) {
            if(Hash::check($request->password, $user->password))
            {                
                Auth::loginUsingId($user->id);
                return response()->json(['status' => 1, 'message' => 'True'], 200); 
            }
        }

        return response()->json(['status' => 0, 'message' => 'Email and Password Not Match'], 200);
    }
}
