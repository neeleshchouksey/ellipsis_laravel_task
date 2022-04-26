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
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('home');
    }

    /**
     * function to short  a given url
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function short_url(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'url' => ['required', 'url'],
        ]);
        if ($validator->fails()) {
            return Redirect::to('/')->with('error', $validator->getMessageBag()->first());
        } else {
            $expiry = strtotime("+5 minutes");
            $str = $this->generateRandomString();
            $u = new Url();
            $u->original_url = $request->url;
            $u->short_url = url('/')."/short-url/".$str;
            $u->expiry = $expiry;
            $u->save();

            $details = ["body"=>"Your short url ". $u->short_url." is expired"];
            dispatch(new SendEmailJob($details))->delay(now()->addMinutes(5));

            return Redirect::to('/shortened-url');
        }
    }

    /**
     * show success page after shortened url
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shortened_url(Request $request){
        $u = Url::orderBy("id","desc")->first();
        return view('shortened-url',['url'=>$u]);
    }

    /**
     * function to generate random string
     * @param $length
     * @return string
     */

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * redirect user from short url to it's original url
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */

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
