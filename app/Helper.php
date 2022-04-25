<?php

use App\Admin;
use App\FreeSubscription;
use Illuminate\Support\Facades\Auth;

function get_auth_user(){
    $id = Auth::guard('admin')->user()->id;
    $admin = Admin::find($id);
    return $admin;
}

?>
