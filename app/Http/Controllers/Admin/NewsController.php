<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//PHP14 以下を追記　News Modelが扱えるようになる
use App\News;
//PHP17追記　History Modelも
use App\History;

use Carbon\Carbon;
use Storage; //heroku追加


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
            $path = Storage::disk('s3')->putFile('/', $form['image'], 'public');
            $news->image_path = Storage::disk('s3')->url($path);
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
            //Newsモデルを使い、DBに保存されているNewsテーブルのレコードを全て���得し変数$postsに代入
            $posts = News::all();
        }
        
        //下記でRequestにcond_titleを送っている
        //index.blade.phpに$postsと$cond_titleを渡してページを開く
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    
    //PHP16追記
    public function edit(Request $request)
    {
        //News Modelからデータを取得
        $news = News::find($request->id);
        if (empty($news)) {
            abort(404);
        }
        return view('admin.news.edit', ['news_form' => $news]);
    }
    
    public function update(Request $request)
    {
        //Validationをかける
        $this->validate($request, News::$rules);
        //News Modelからデータを取得する
        $news = News::find($request->id);
        //送信されてきたフォームデータを格納する（画像もあることを忘れずに）
        $news_form = $request->all();
        if (isset($news_form['image'])) {
            $path = Storage::disk('s3')->putFile('/', $form['image'], 'public');
            $news->image_path = Storage::disk('s3')->url($path);
            unset($news_form['image']);
        } elseif (isset($request->remove)) {
            $news->image_path = null;
            unset($news_form['remove']);
        }
        unset($news_form['_token']);
        
        //該当するデータを上書きして保存する
        $news->fill($news_form)->save();
        
        //PHP17追記
        $history = new History;
        $history->news_id = $news->id;
        //↓「Carbon」と言う日付操作ライブラリを使用して取得した日付を、HistoryモデルのEdited＿atとして記録
        $history->edited_at = Carbon::now();
        $history->save();
        
        return redirect('admin/news');
    }
    
    
    //データの削除
    public function delete(Request $request)
    {
        //該当するNews Modelを取得
        $news = News::find($request->id);
        //削除 deleteメソッドを使用
        $news->delete();
        return redirect('admin/news/');
    }
}

