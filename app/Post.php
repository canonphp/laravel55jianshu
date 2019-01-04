<?php

namespace App;

use App\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id','content','title'
    ];

    //关联用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    //评论模型
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at','desc');
    }

    //和用户进行关联
    public function zan($user_id)
    {
        return $this->hasOne(Zan::class)->where('user_id',$user_id);
    }

    //文章的所有赞
    public function zans()
    {
        return $this->hasMany(Zan::class);
    }


}
