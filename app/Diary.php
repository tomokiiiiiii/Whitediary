<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    protected $fillable=[
        'diary',
        'user_id',
    
    ];
    
    
    
    public function getPaginateByLimit(int $limit_count = 5)
    {
        return $this::with('user')->orderBy('updated_at','DESC')->paginate($limit_count);
    }
    
    public function user()
    {
    return $this->belongsTo('App\User');
    }
}
