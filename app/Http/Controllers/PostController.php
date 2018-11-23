<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    //
    //文章列表
    public function index()
    {



        \Log::info("post_index",['data'=>'this is post index']);

        $posts = Post::orderBy('created_at','desc')->paginate(3);
        return view('post.index',compact('posts'));

    }
    //文章详情
    public function show(Post $post)
    {
        return view('post.show',compact('post'));

    }

    //添加文章
    public function create()
    {

        return view('post.create');
    }

    //创建逻辑
    public function store()
    {
        //验证
        $this->validate(\request(),[
            'title'=>'required|string|max:30|min:5',
            'content'=>'required|string|min:10'
        ]);
        $post = Post::create(\request(['title','content']));
        if ($post){
            return redirect('/posts');
        }

    }

    //编辑文章页
    public function edit(Post $post)
    {

        return view('post.edit',compact('post'));

    }

    //更新文章
    public function update(Post $post)
    {
        //验证
        $this->validate(request(),[
            'title'=>'required|string|max:30|min:5',
            'content'=>'required|string|min:10'
        ]);

        $post->title = request('title');
        $post->content = request('content');
        $post->save();
        //逻辑
        return redirect("/posts/{$post->id}");
    }

    //删除文章
    public function delete(Post $post)
    {
        /*TODO验证权限*/
        $post->delete();
        return redirect("/posts");

    }


    //图片上传
    public function imageUpload(Request $request)
    {

        //dd($request->all());
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/'.$path);

    }

}










