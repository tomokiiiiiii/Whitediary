<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diary extends Model
{
     use SoftDeletes;
     
    protected $fillable=[
        'diary',
        'user_id',
    
    ];
    
    
    
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

}
