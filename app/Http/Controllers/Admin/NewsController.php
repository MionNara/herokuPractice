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
        // Varidationを行う（News::$rulesは、News.phpファイルの$rules変数を呼び出す）
        $this->validate($request,News::$rules);
        
        //new:モデルからインスタンス（レコード）を生成
        $news = new News;
        //formで入力された値を取得
        $form = $request->all();
        
        //フォームから画像が送信されてきたら保存して$news->image_pathに画像のパスを保存する
        //issetメソッド：引数の中にデータがあるか判断するメソッド
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
    
    
    //PHP15 追記
    public function index(Request $request)
    {
        
        //$requestの中のcond_titleの値を$cond_titleに代入
        $cond_title = $request->cond_title;
        if ($cond_title != '') {
            //検索されたら検索結果を取得する　Modelに対しWhereメソッドを指定して検索
            //Newsテーブルのtitleカラムで$cond_title(ユーザーが入力した文字)に一致するレコードを全て取得
            $posts = News::where('title', $cond_title)->get();
        }else{
            //それ以外は全てのニュースを取得する
            //Newsモデルを使い、DBに保存されているNewsテーブルのレコードを全て取得し変数$postsに代入
            $posts = News::all();
        }
        
        //下記でRequestにcond_titleを送っている
        //index.blade.phpに$postsと$cond_titleを渡してページを開く
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
}


