<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Zan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
    //
    //文章列表
    public function index()
    {


        \Log::info("post_index",['data'=>'this is post index']);

        $posts = Post::orderBy('created_at','desc')->withCount(['comments','zans'])->paginate(3);

        return view('post.index',compact('posts'));

    }
    //文章详情
    public function show(Post $post)
    {
        //$this->load('comments');
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
        $user_id = \Auth::user()->id;
        $params = array_merge(request(['title','content']),compact('user_id'));
        $post = Post::create($params);
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
        $this->authorize('update',$post);

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

    /**提交评论
     * @param Post $post
     */
    public function comment(Post $post)
    {
        $this->validate(\request(),[
//            'post_id' => 'required|exists:posts,id',
            'content'=>'required|min:3'
        ]);
        //逻辑

        $comment  =  new Comment();
        $comment->user_id = \Auth::user()->id;
        $comment->content = \request('content');
        $post->comments()->save();
        /*$user_id  = \Auth::user()->id;
        $params = array_merge(
            \request(['post_id', 'content']),
            compact('user_id')
        );
        Comment::create($params);*/
        //渲染
        return back();
    }

    public function zan(Post $post)
    {
        $params =  [
            'user_id'=> \Auth::user()->id,
            'post_id'=>$post->id
        ];

        Zan::firstOrCreate($params);
        return back();
    }

    public function unzan(Post $post)
    {
        $post->zan(\Auth::user()->id)->delete();
        return back();

    }


}










