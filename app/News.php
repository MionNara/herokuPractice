<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //追記
    protected $guarded = array('id');
    
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
        );
    
    //Valitationでデータが異常であることを見つけた時には、データを保存せずに入力フォームへ戻す
}
