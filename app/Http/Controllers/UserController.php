<?php

namespace App\Http\Controllers;
use App\User;
use App\Diary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\FollowUser;
use App\DiaryUser;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    
  public function mypage(User $user,Request $request)
    {
    $auth_id=Auth::user()->id;
    if($user->id==$auth_id){
      //mypageのユーザーとログイン主が同じだった時の挙動
      $diaries=new Diary;
      $diaries=Diary::where('user_id',Auth::user()->id)->orderBy('updated_at','DESC')->paginate(5);
      
    }
     //mypageのユーザーとログイン主が違う時の挙動
    else{
      $diaries=Auth::user()->getPaginateByLimit();
    }
    return view('mypage')->with([
    'user'=>$user,
    'auth_id'=>$auth_id,
    'diaries' => $diaries,
    ]);
    }
    
  public function delete(Diary $diary_id)
    {
    $diary_id->delete();
    return redirect('/');
    }
    
  public function search()
  {
    return view('search');
  }
  
  public function follow(Request $request)
  {
        $input = $request['search'];
        $user_id=$input['user_id'];
        $name=$input['name'];
        if( DB::table('users')->where('id',$user_id)->where('name',$name)->exists()){
          if(!DB::table('follow_users')->where('following_user_id',Auth::id())->where('followed_user_id',$user_id)->exists()){
            if($user_id!=Auth::id()){
              $user=Auth::user();
              $user->follows()->attach(['followed_user_id'=>$user_id],['following_user_id'=>$user->id]);
              return redirect('/');
            }
          }
        }
        return redirect('/search');
        
  }
  public function list(FollowUser $followUser)
  {
    $user=Auth::user();
    return view('list')->with(['following_user_ids' => $user]);
  }
  
  public function follows_delete(User $user)
  {
    $user_id=Auth::id();
    $user->followUsers()->detach(['following_user_id'=>$user_id]);
   
    
    return redirect('/list');
  }
    
  public function select_user(User $user)
  {
    $user=Auth::user();
    $allowed_users =$user->followUsers()->get();
    return view('/select')->with(['followed_users_id' => $allowed_users]);
   
  }
  
  public function store(UserRequest $request)
  {
    $select_users= $request->users_array;
    $user=Auth::user();
    $all_diaries=$user->diaries();
    $latestdiary=$all_diaries->orderBy('updated_at','DESC')->limit(1)->first()->id;
    foreach($select_users as $select_user){
      $user->selectdiaries()->attach(['diary_id'=>$latestdiary],['user_id'=>$select_user]);
    }
    return redirect('/select/'.$latestdiary)->with(['latestdiary' => $latestdiary]);
    }
    
  public function cancel()
    {
    $user=Auth::user();
    $all_diaries=$user->diaries();
    $latestdiary=$all_diaries->orderBy('updated_at','DESC')->limit(1)->first();
    $latestdiary->delete();
    return redirect('/');
    }
}

