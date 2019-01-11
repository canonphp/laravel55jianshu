<?php

namespace App;

use App\Model;
use Illuminate\Database\Eloquent\Builder;
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

    public function postTopics()
    {
        return  $this->hasMany(PostTopic::class,'post_id','id');
    }


    //属于某个作者的文章
    public function scopeAuthorBy(Builder $query,$user_id)
    {
        return $query->where('user_id',$user_id);

    }

    //不属于某个专题的文章
    public function scopeTopicNotBy(Builder $query,$topic_id)
    {
        return $query->doesntHave('postTopics','and',function ($q) use ($topic_id){
            $q->where('topic_id',$topic_id);
        });

    }


}
