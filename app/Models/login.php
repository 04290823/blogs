<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class login extends Model
{
    //表名
    protected $table='users';
    //判断登录
    public function login($data){
        $user = self::where(['user'=>$data['user'],'password'=>$data['password']])->first();
        if ($user){
            return $user->toArray();
        }else{
            return 0;
        }
    }
}
