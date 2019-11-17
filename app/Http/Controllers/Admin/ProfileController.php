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
        
        $profiles = new Profile;
        $form = $request->all();
        
        unset($form['_token']);
        
        $profiles->fill($form);
        $profiles->save();
        
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
        $profiles = Profile::find($request->id);
        if (empty($plofiles)) {
            abort(404);
        }
        return view('admin.profile.edit', ['plofile_form' => $plofiles]);
    }
    
    public function update(Request $request)
    {
        $this->validate($request, Plofile::$rules);
        $plofiles = Plofile::find($request->id);
        $plofiles_form = $request->all();
        unset($plofiles_form['_token']);
        $plofiles->fill($plofiles_form)->save();
        
        return redirect('admin/profile');
    }
    
    public function delete(Request $request)
    {
        $plofile = Plofile::find($request->id);
        $plofile->delete();
        return redirect('admin/plofile/');
    }
}