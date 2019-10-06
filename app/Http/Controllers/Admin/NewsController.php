<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    // 以下を追記 NewsControllerにaddというactionを実装
    public function add ( )
    {
        return view('admin.news.create');
    }
    
    //PHP13 以下を追記
    public function create(Request $request)
    {
        // admin/news/createへリダイレクト
        return redirect('admin/news/create');
    }

}


