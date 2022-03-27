<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Diary extends Model
{
     use SoftDeletes;
     
    protected $fillable=[
        'diary',
        'user_id',
    
    ];
    
    protected $table = 'diaries';
    
    
    public function getPaginateByLimit(int $limit_count = 5)
    {   
        return $this->orderBy('updated_at','DESC')->paginate($limit_count);
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function select_users()
    {
        return $this->belongsToMany('App\User');
    }
    
     public function likes()
    {
        return $this->hasMany('App\Like', 'diary_id');
    }

  /**
   * リプライにLIKEを付いているかの判定
   *
   * @return bool true:Likeがついてる false:Likeがついてない
   */

    public function is_liked_by_auth_user()
    {
    $id = Auth::id();

    $likers = array();
      foreach($this->likes as $like) {
      array_push($likers, $like->user_id);
      }

    if (in_array($id, $likers)) {
       return true;
    } else {
       return false;
    }
   }
   
   
   
   //public function method
}

