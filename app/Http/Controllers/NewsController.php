<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;
use App\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        //News::all()でEloquentを使用して全てのnewsテーブルを取得
        //sortByDesc()メソッドで（）の中のキーでソートをしている。Descは降順ということ。投稿日順に新しいものから並び替え
        $posts = News::all()->sortByDesc('updated_at');
    
        if (count($posts) > 0){
            //shift()メソッド：配列の最初のデータを削除し、その値を返す
            //つまり一番最新の記事を変数＄headlineに代入し、＄postsには代入された最新の記事以外の記事が格納されている
            //最新の記事とそのたで表記を変えたいので分けている
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

    //news/index.blade.phpにファイルを渡す
    //また、Viewテンプレートにheadline、posts、と言う変数を渡している
    return view('news.index',['headline' => $headline,'posts' => $posts]);
    }
        
}

