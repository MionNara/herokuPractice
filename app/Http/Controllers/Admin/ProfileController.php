<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//Profile.php Modelを扱えるように追記
use App\Profile;

//PHP17追記
use App\ProfileHistory;
use Carbon\Carbon;



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
        return view('admin.profile.index', ['posts' =>$posts, 'cond_name' => $cond_name]);
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
        $profile_form = $request->all();
        unset($profile_form['_token']);
        $profile->fill($profile_form)->save();
        
        //PHP17 追記
        $profilehistory = new ProfileHistory;
        $profilehistory->profile_id = $profile->id;
        $profilehistory->edited_at = Carbon::now();
        $profilehistory->save();
        
        //URLにクエリを付与
        return redirect('admin/profile/edit?id='. $request->id); 
    }
    
    public function delete(Request $request)
    {
        $profile = Profile::find($request->id);
        $profile->delete();
        return redirect('admin/profile/create');
    }
}