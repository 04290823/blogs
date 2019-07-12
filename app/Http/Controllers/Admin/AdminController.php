<?php

namespace App\Http\Controllers\Admin;

use App\Models\login;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * 后台登录页面
     */
    function admin(){
        return view('admin/login');
    }

    /**
     * 登录
     */
    function login(Request $request){
        //验证用户名、密码和验证码是否为空   验证码是否正确
        $this->validate($request,[
            'user'=>'required',
            'pwd'=>'required',
            'captcha' => 'required|captcha'
        ],[
            'user.required' => '用户名不能为空',
            'pwd.required' => '密码不能为空',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '请输入正确的验证码',
        ]);
        $data['user'] = Input::post('user');
        $data['password'] = Input::post('pwd');
        //使用model
        $user = new login();
        $confirm = $user->login($data);
        $session_user['id'] = $confirm['id'];
        $session_user['user'] = $confirm['user'];
        //判断是否登录成功
        if ($confirm){
            //储存session
            Session::put('users',$session_user);
            //登录成功
            return redirect()->route('show');
        }else{
            //登录失败提示
            return view('admin/skip')->with([
                'message'=>'您的用户名或密码错误',
                'url' =>url('admin'),
                'jumpTime'=>3,
            ]);
        }
    }

    /**
     * 退出
     */
    public function quit(){
        //判断session是否存在
        if (Session::has('users')){
            //清除登录的信息
            Session::forget('users');
            //退出成功后
            return view('admin/skip')->with([
                'message'=>'退出成功',
                'url' =>url('admin'),
                'jumpTime'=>3,
            ]);
        }else{
            //退出失败
            return '退出失败';
        }
    }
}
