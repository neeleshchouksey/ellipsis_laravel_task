<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Message;
use App\UserCard;
use App\Url;
use Illuminate\Http\Request;
use App\Upload;
use DB;
use FFMpeg;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('home');
    }

    public function short_url(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'url' => ['required', 'url'],
        ]);
        if ($validator->fails()) {
            return Redirect::to('/')->with('error', $validator->getMessageBag()->first());
        } else {
            $expiry = strtotime("+2 minutes");
            $str = $this->generateRandomString();
            $u = new Url();
            $u->original_url = $request->url;
            $u->short_url = url('/')."/short-url/".$str;
            $u->expiry = $expiry;
            $u->save();

            $details = ["body"=>"Your short url ". $u->short_url." is expired"];
            dispatch(new SendEmailJob($details))->delay(now()->addMinutes(2));

            return Redirect::to('/shortened-url');
        }
    }
    public function shortened_url(Request $request){
        $u = Url::orderBy("id","desc")->first();
        return view('shortened-url',['url'=>$u]);
    }

    public function getMessages(){

        return Message::orderBy('created_at', 'desc')->get();
    }
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function redirect_from_short_url(Request $request){
        $url = $request->url();
        $u = Url::withTrashed()->where('short_url',$url)->first();
        if(!$u){
            return Redirect::to('/')->with('error','Your short url does not exist');
        }else if($u->expiry<time()){
            return Redirect::to('/')->with('error','Your short url is expired');
        }elseif ($u->deleted_at){
            return Redirect::to('/')->with('error','Your short url is disabled by admin');
        }else{
            return view('redirect-from-short-url',['url'=>$u->original_url]);
        }

    }

}
