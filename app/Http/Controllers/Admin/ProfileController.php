<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//Profile.php Modelを扱えるように追記
use App\Profiles;


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
        
        $this->validate($request,Profiles::$rules);
        
        $profile = new Profiles;
        $form = $request->all();
        
        unset($form['_token']);
        
        $profile->fill($form);
        $profile->save();
        
        return redirect('admin/profile/create');
    }
    
    public function edit( )
    {
        return view('admin.profile.edit');
    }
    
    public function update( )
    {
        return redirect('admin/profile/edit');
    }
    
    //add やcreateというのがaction
}
