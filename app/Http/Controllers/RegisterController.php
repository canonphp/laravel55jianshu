<?php

namespace App\Http\Controllers;

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


    }

}
