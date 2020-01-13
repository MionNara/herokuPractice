<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use ProfileHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    Public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if($cond_name != '') {
        }else{
            $posts = Profile::all();
        }
        return view('profile.index',['post'=>$posts,'cond_name'=>$cond_name]);
    }
}
