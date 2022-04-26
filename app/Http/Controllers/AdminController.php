<?php

namespace App\Http\Controllers;

use App\Admin;

use App\Rules\MatchOldPassword;
use App\Url;
use Illuminate\Http\Request;
use DB;
use FFMpeg;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application admin login page.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('admin.login');
    }

    /**
     *  function for admin login
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function admin_login(Request $request)
    {

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/admin/dashboard');
        } else {
            return redirect(url('/admin'))->with('error', 'Invalid Credentials');
        }
    }

    /**
     * show admin dashboard
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     *  show admin profile
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        $id = Auth::guard('admin')->user()->id;
        $admin = Admin::find($id);
        return view('admin.profile', ['admin' => $admin]);
    }

    /**
     * function for admin logout
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    /**
     * show url listing page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function urls()
    {

        return view('admin.urls');
    }

    /**
     *  function to get all urls
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_urls()
    {
        $data = Url::withTrashed()->orderBy('id', 'desc')->get();

        foreach ($data as $k => $v) {
            $v->sno = $k + 1;
            $v->expiry = date("d/m/Y h:i A", $v->expiry);

            $editBtn = "<button class='btn btn-sm btn-primary mb-2' onclick='getSingleUrl($v->id)'>Edit</button>";
            $deleteBtn = "<button class='btn btn-sm btn-danger mb-2' onclick='deleteUrl($v->id)'>Delete</button>";

            if ($v->deleted_at) {
                // activate Button
                $deleteButton = "<button class='btn btn-sm btn-success' onclick='activateDeactivateUrl($v->id,1)'>Activate</button>";

            } else {
                // Deactivate Button
                $deleteButton = "<button class='btn btn-sm btn-danger' onclick='activateDeactivateUrl($v->id,0)'>Deactivate</button>";
            }
            if (!$v->deleted_at) {
                $action = $editBtn . "<br>" . $deleteBtn . "<br>" . $deleteButton;
            } else {
                $action = $deleteButton;
            }
            $v->action = $action;

        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        return response()->json($results);
    }

    /**
     * function to activate deactivate url
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function activate_deactivate_urls(Request $request)
    {
        if (!$request->status) {
            $st = "Deactivated";
            $url = Url::find($request->id)->delete();
        } else {
            $st = "Activated";
            $url = Url::withTrashed()->find($request->id)->restore();
        }
        return response(["status" => "success", "msg" => "Url " . $st . " successfully"], 200);
    }

    /**
     * function to delete url
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete_urls(Request $request, $id)
    {
        $url = Url::find($id)->forceDelete();
        return response(["status" => "success", "msg" => "Url deleted successfully"], 200);
    }

    /**
     * function to get url details by id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function get_url(Request $request, $id)
    {
        $url = Url::find($id);
        $url->expiry = date("Y-m-d", $url->expiry);
        return response(["status" => "success", "res" => $url], 200);
    }

    /**
     * function to update url
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */

    public function update_url(Request $request)
    {
        $u = Url::find($request->id);
        $u->original_url = $request->original_url;
        $u->expiry = strtotime($request->expiry);
        $u->short_url = $request->short_url;
        $u->save();
        return response(["status" => "success", "msg" => "Url updated successfully"], 200);

    }

    /**
     * function to update profile
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        $u = Admin::find($request->id);
        $u->name = $request->name;
        $u->save();
        return response(["status" => "success", "msg" => "Profile updated successfully"], 200);

    }
}
