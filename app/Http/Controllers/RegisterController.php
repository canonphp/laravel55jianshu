<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //注册页面
    public function index()
    {
        return view('register.index');
    }

    //注册行为



    public function register()
    {
        //验证
        $this->validate(request(),[
            'username'=>'required|min:3|unique:users,username',
            'email'=>'required|unique:users,email|email',
            'password'=>'required|min:5|confirmed'
        ]);
        //逻辑
        $username = \request('name');
        $email = \request('email');
        $password = bcrypt(\request('password'));
        $user = User::create(compact('name','email','password'));
        if ($user){
            return redirect('/login');
        }
        //渲染


    }

}
