<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
//追記
    
    protected $guarded = array('id');
    
    //Varidation
    public static $rules = array(
        'name' => 'required',
        'gender' => 'required',
        'hobby' => 'required',
        'introduction' => 'required',
    );
   
}
