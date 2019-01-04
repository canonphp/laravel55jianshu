<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //登录页面
    public function index()
    {

        return view('login.index');

    }

    //登录行为
    public function login()
    {
        //验证
        $this->validate(\request(),[
            'email'=>'required|email',
            'password'=>'required|min:5',
            'is_remember'=>'integer'
        ]);
        //逻辑
        $user = \request(['email','password']);
        $remember  = boolval(\request('is_remember'));
        if (\Auth::attempt($user,$remember)){
            return redirect('posts/');

        }

        return \Redirect::back()->withErrors("用户名密码错误");

    }

    //登出行为
    public function logout()
    {
        \Auth::logout();

         return redirect('/login');

    }

}
