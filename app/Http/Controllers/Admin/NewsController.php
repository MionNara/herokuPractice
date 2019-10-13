<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//PHP14 以下を追記　News Modelが扱えるようになる
use App\News;


class NewsController extends Controller
{
    // 以下を追記 NewsControllerにaddというactionを実装
    public function add ( )
    {
        return view('admin.news.create');
    }
    
    //PHP13 以下を追記　createアクション
    public function create(Request $request)
    {
        
        //PHP14 以下を追記
        // Varidationを行う
        $this->validate($request,News::$rules);
        
        $news = new News;
        $form = $request->all();
        
        //フォームから画像が送信されてきたら保存して$news->image_pathに画像のパスを保存する
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $news->image_path = basename($path);
        } else {
            $news->image_path = null;
        }
        
        //フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        //フォームから送信されてきたimageを削除する
        unset($form['image']);
        
        //データベースに保存
        $news->fill($form);
        $news->save();
        
        // admin/news/createへリダイレクト
        return redirect('admin/news/create');
    }

}


