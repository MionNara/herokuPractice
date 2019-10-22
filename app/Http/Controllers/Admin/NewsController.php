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
    //このRequestクラスはブラウザを通してユーザーから送られる情報を全て含んでいるオブジェクトを取得できる
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
    
    public function index(Request $request)
    {
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            //検索されたら検索結果を取得する
            $posts = News::where('title', $cond_title)->get();
        }else{
            //それ以外は全てのニュースを取得する
            $post = News::all();
        }
        return view('admin.news.index', ['post' => $posts, 'cond_title' -> $cond_title]);
    }
}


