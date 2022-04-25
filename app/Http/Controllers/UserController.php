<?php

namespace App\Http\Controllers;

use App\FreeSubscription;
use App\Rules\MatchOldPassword;
use App\UserCard;
use App\User;
use Illuminate\Http\Request;
use App\Upload;
use Facade\FlareClient\Stacktrace\File;
use FFMpeg;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
        $title = "Dashboard";

        return view('dashboard', compact('title'));
    }

    public function profile()
    {
        $title = "Profile";
        $countries = DB::table("countries")->get();
        $user = User::find(Auth::user()->id);
        return view('profile', ["user" => $user, "title" => $title, "countries" => $countries]);
    }

    public function change_password()
    {
        $title = "Change Password";
        return view('change-password');
    }

    public function update_profile(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'streetaddress' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'zipcode' => ['required'],

        ]);
        if ($validator->fails()) {
            return Redirect::to('/profile')->with('error', $validator->getMessageBag()->first());
        } else {

            $user = User::find(Auth::user()->id);

            if($request->file("profile_image")){
                $file = $request->file("profile_image");
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName);

                if($user->profile_name != "default.png"){
                    unlink(public_path('uploads')."/".$user->profile_image);
                }

                $user->profile_image = $fileName;
            }

            $user->name = $request->name;
            $user->address = $request->streetaddress;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->country = $request->country;
            $user->zip_code = $request->zipcode;
            $user->save();

            return Redirect::to('/profile')->with('alert', 'Profile Updated Successfully');
        }
    }

    public function change_user_password(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'old_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['same:new_password'],
        ]);
        if ($validator->fails()) {
            return Redirect::to('/change-password')->with('error', $validator->getMessageBag()->first());
        } else {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();

            return Redirect::to('/change-password')->with('alert', 'Password Changed Successfully');
        }
    }

    function deactivate_account(){
        $user = User::find(Auth::user()->id)->delete();
        Auth::logout();
        return response(["status" => "success", "msg" => "Account deactivated successfully"], 200);

    }

}
