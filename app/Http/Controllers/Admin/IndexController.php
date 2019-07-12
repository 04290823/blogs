<?php

namespace App\Http\Controllers\Admin;

use App\Models\control;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class IndexController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * 管理页面
     */
    public function show(){
        //取出我登录的用户
        $user = Session::get('users');
        $user_id = $user['id'];
        //使用model
        $control = new control();
        //查询用户是什么角色
        $role = $control->role($user_id);
        //查询用户有什么权限
        $manage = $control->control($user_id);
        //查询管理员的个人资料
        $personal_data = $control->personal($user_id);
        return view('admin/index',['data'=>$manage,'user'=>$user,'role'=>$role,'personal_data'=>$personal_data]);
    }
}