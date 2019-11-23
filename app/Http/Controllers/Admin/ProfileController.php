<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//Profile.php Modelを扱えるように追記
use App\Profile;


class ProfileController extends Controller
{
    //各種Actionを実装
    
    public function add ( )
    {
        return view('admin.profile.create');
    }
    
    //PHP14 追記・変更
    public function create(Request $request)
    {
        
        $this->validate($request,Profile::$rules);
        
        $profile = new Profile;
        $form = $request->all();
        
        unset($form['_token']);
        
        $profile->fill($form);
        $profile->save();
        
        return redirect('admin/profile/create');
    }
    
    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
        }else{
            $posts = Profile::all();
        }
        return view('admin.news.index', ['posts' =>$posts, 'cond_name' => $cond_name]);
    }
    
    public function edit(Request $request)
    {
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    
    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        $profile = Profile::find($request->id);
        $profileofile_form = $request->all();
        unset($profileofile_form['_token']);
        $profile->fill($profileofile_form)->save();
        
        return redirect('admin/profile');
    }
    
    public function delete(Request $request)
    {
        $profile = Profile::find($request->id);
        $profile->delete();
        return redirect('admin/profile/');
    }
}